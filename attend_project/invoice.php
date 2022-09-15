<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        p{
            padding: 0px;
            margin: 0px;
        }
        .box1 {
            text-decoration:underline;
            text-decoration-color:#000000;
            margin:0.5% 0%;
        }
        .double {
            border: none;
            background-color: #fff;
            border-width: 0;
            border-top: double;
            border-color: black;
            padding:0px;
        }
    </style>
    <?php require("base_infomation.php");
        session_start();

    if(isset($_GET['month']) && isset($_GET['children_name'])){
        $month = $_GET['month'];
        $children_name = $_GET['children_name'];
    }else{
        $month = "";
        $children_name = "";
    }
        $month_item = date('Y年m月', strtotime($month));
        $month = date('t', strtotime($month));
        $today = date("Y年m月d日");
        $ded_line = date('Y年m月10日', strtotime(date('Y-m-d').'+1 month'));
        $number = date("Ymd");

        if($children_data = $DB->query("SELECT children_id,children_family,children_contract_type,family_level,decrease_tax from children_info where children_name like '%".$children_name."%'")){
            $children_id = $children_data ->fetch();
            $children_family = json_decode( $children_id['children_family'] , true ) ; //家族情報をjson形式から変換
            $print_number = "CSN".$number.$children_id['children_id']."-01";
            $int = $children_id['family_level'] - 1;
            if($children_id['children_contract_type'] == "通常保育"){
                $children_contract_type = [0,0,8000,10000,12500,19500,33000,44000,55000,60000,72800];
                $children_contract_time_A = "07:30:00";
                $children_contract_time_B = "18:30:00";
            }
            if($children_id['children_contract_type'] == "短縮保育"){
                $children_contract_type = [0,0,7800,9800,12200,19100,32400,43200,54000,58900,71500];
                $children_contract_time_A = "08:30:00";
                $children_contract_time_B = "16:30:00";
            }

            $children_contract_type_total = $children_contract_type[$int] - $children_id['decrease_tax'];//通常保育・短縮保育料金計
            $cost_total = 0;    //諸経費計
            $attend_cost_total = 0;     //延長保育料計
            $seikyu_cost_total = 0;     //請求合計
            $not_payment = 0;       //未入金計
        }
        else{
            echo"検索できませんでした";
        }
?>
    <title>請求書</title>
</head>
<body>
<div class="container bg-dark text-white">
        <h2>諸経費利用履歴</h2>
            <form action="invoice.php" method="GET">
                <div class="row">
                    <div class="col-4">
                        <p>日付（月）</p>
                        <input type="month" name="month" value="" required>
                    </div>
                    <div class="col-4">
                        <p>園児名</p>
                        <input type="text" name="children_name" value="" required>
                    </div>
                    <div class="col-4">
                        <input type="hidden" name="type" value="cost">
                        <input type="submit" value="検索">
                    </div>
                </div>
            </form>
    </div>
    <div class="container">
    <form action="testPDF.php" method ="POST">
    <?php if(isset($_GET['month']) && isset($_GET['children_name'])):?>
        <div class="row">
            <div class="col-8">
                <p><?php print($children_family[0]['name']);?>　様</p>
                <p>園児名　　<?php print($children_name);?></p>
            </div>
        </div>
        <h2 class="text-center"><?php print($month_item);?>分保育料請求書</h2>
        <p>下記の通り保育代金を請求いたします。<br>代金のお支払いは、<input type="date" name = "dedLine" required>までに下記の入金方法にてお願いいたします。</p>
        <div class="row">
            <div class="col-6 order-1">
                <?php
                    for($i=1; $i <= 15; $i++):
                    $date_data = $_GET['month'];

                    //日付の作成
                    if($i < 10){
                        $date_data .= "-0";
                        $date_data .= $i;
                    }else{
                        $date_data .= "-";
                        $date_data .= $i;
                    }
                ?>
                    <div class="row">
                    <?php
                        $data = $DB->query("SELECT id,children_attend,children_datetime from children_attend where children_datetime like '%".$date_data."%' AND children_id = '".$children_id['children_id']."'");
                        $item = $data->fetchAll();
                        //print_r($item);
                        $children_date ="";
                        $children_date_time_total ="";
                        if(isset($item[0]['id'])){
                            $children_date_time = strtotime($item[0]['children_datetime']);
                            $children_limit_time = new Datetime();
                            $children_limit_time = $children_limit_time ->format($date_data.$children_contract_time_A);
                            $children_limit = strtotime($children_limit_time);
                            if($item[0]['children_attend'] == "登園"){
                                if($children_limit > $children_date_time){
                                    $children_date_time_total = date('H:i:s', strtotime($item[0]['children_datetime']));
                                    //30分毎に計算
                                    $children_date = ceil(($children_limit - $children_date_time)/60/30)*500;
                                    $attend_cost_total = $attend_cost_total + $children_date;

                                    if($item[1]['children_attend'] == "降園" || $item[1]['children_attend'] == "自動退勤"){
                                        $children_date_time = strtotime($item[1]['children_datetime']);
                                        $children_date_time_total .= "　".date('H:i:s', strtotime($item[1]['children_datetime']));
                                        $children_limit_time = new Datetime();
                                        $children_limit_time = $children_limit_time ->format($date_data.$children_contract_time_B);
                                        $children_limit = strtotime($children_limit_time);
                                        if($children_date_time > $children_limit){
                                            //30分毎に計算
                                            $children_date .= "　".ceil(($children_date_time - $children_limit)/60/30)*500;
                                            $attend_cost_total = $attend_cost_total + ceil(($children_date_time - $children_limit)/60/30)*500;
                                        }
                                        else{
                                            $children_date_time_total .= "";
                                            $children_date .= "　なし";
                                        }
                                    }
                                }elseif($item[1]['children_attend'] == "降園" || $item[1]['children_attend'] == "自動退勤"){
                                    $children_date_time = strtotime($item[1]['children_datetime']);
                                    $children_limit_time = new Datetime();
                                    $children_limit_time = $children_limit_time ->format($date_data.$children_contract_time_B);
                                    $children_limit = strtotime($children_limit_time);
                                    if($children_date_time > $children_limit){
                                        //30分毎に計算
                                        $children_date_time_total .= "　".date('H:i:s', strtotime($item[1]['children_datetime']));
                                        $children_date .= "　".ceil(($children_date_time - $children_limit)/60/30)*500;
                                        $attend_cost_total = $attend_cost_total + ceil(($children_date_time - $children_limit)/60/30)*500;
                                    }
                                    else{
                                        $children_date_time_total .= "";
                                        $children_date .= "　";
                                    }

                                }
                            }
                            elseif(isset($item[0]['id'])){
                                if($item[0]['children_attend'] == "降園" || $item[0]['children_attend'] == "自動退勤"){
                                    $children_date_time_total = date('H:i:s', strtotime($item[0]['children_datetime']));
                                    $children_date_time = strtotime($item[0]['children_datetime']);
                                    $children_limit_time = new Datetime();
                                    $children_limit_time = $children_limit_time ->format($date_data.$children_contract_time_B);
                                    $children_limit = strtotime($children_limit_time);

                                    if($children_date_time > $children_limit){
                                        //30分毎に計算
                                        $children_date = ceil(($children_date_time - $children_limit)/60/30)*500;
                                        $attend_cost_total = $attend_cost_total + $children_date;
                                    }
                                    else{
                                        $children_date_time_total = "";
                                        $children_date = "なし";
                                    }
                                }
                            }else{$children_date = "なし"; $children_date_time_total = "";}
                        }else{$children_date = "なし"; $children_date_time_total = "";}
                    ?>
                         <div class="col-2" style="border: 1px solid">
                            <p><?php print($i);?>日</p>
                        </div>
                        <div class="col-6" style="border: 1px solid">
                            <?php if(isset($children_date_time_total)){print($children_date_time_total);}else{echo"";} ?>
                        </div>
                        <div class="col-2 text-center" style="border: 1px solid">
                            <?php print($children_date);?>
                        </div>
                    </div>
                    <?php
                    if($i==1){$attend_cost_array = '{"date_name":"'.$i.'","children_datetime_total":"'.$children_date_time_total.'","children_date":"'.$children_date.'"},';}
                    else{$attend_cost_array .= '{"date_name":"'.$i.'","children_datetime_total":"'.$children_date_time_total.'","children_date":"'.$children_date.'"},';}
                    endfor;
                    ?>
            </div>
            <div class="col-6 order-2">
                <?php
                    for($i=16; $i <= $month; $i++):
                    $date_data = $_GET['month'];
                    if($i < 10){
                        $date_data .= "-0";
                        $date_data .= $i;
                    }else{
                        $date_data .= "-";
                        $date_data .= $i;
                    }
                ?>
                    <div class="row">
                    <?php
                        $data = $DB->query("SELECT id,children_attend,children_datetime from children_attend where children_datetime like '%".$date_data."%' AND children_id = '".$children_id['children_id']."'");
                        $item = $data->fetchAll();
                        //print($item[1]['children_attend']);
                        $children_date ="";
                        $children_date_time_total ="";
                        if(isset($item[0]['id'])){
                            $children_date_time = strtotime($item[0]['children_datetime']);
                            $children_limit_time = new Datetime();
                            $children_limit_time = $children_limit_time ->format($date_data.$children_contract_time_A);
                            $children_limit = strtotime($children_limit_time);
                            if($item[0]['children_attend'] == "登園"){
                                if($children_limit > $children_date_time){
                                    $children_date_time_total = date('H:i:s', strtotime($item[0]['children_datetime']));
                                    //30分毎に計算
                                    $children_date = ceil(($children_limit - $children_date_time)/60/30)*500;
                                    $attend_cost_total = $attend_cost_total + $children_date;

                                    if($item[1]['children_attend'] == "降園" || $item[1]['children_attend'] == "自動退勤"){
                                        $children_date_time = strtotime($item[1]['children_datetime']);
                                        $children_date_time_total .= "　".date('H:i:s', strtotime($item[1]['children_datetime']));
                                        $children_limit_time = new Datetime();
                                        $children_limit_time = $children_limit_time ->format($date_data.$children_contract_time_B);
                                        $children_limit = strtotime($children_limit_time);
                                        if($children_date_time > $children_limit){
                                            //30分毎に計算
                                            $children_date .= "　".ceil(($children_date_time - $children_limit)/60/30)*500;
                                            $attend_cost_total = $attend_cost_total + ceil(($children_date_time - $children_limit)/60/30)*500;
                                        }
                                        else{
                                            $children_date_time_total .= "";
                                            $children_date .= "　なし";
                                        }
                                    }
                                }elseif($item[1]['children_attend'] == "降園" || $item[1]['children_attend'] == "自動退勤"){
                                    $children_date_time = strtotime($item[1]['children_datetime']);
                                    $children_limit_time = new Datetime();
                                    $children_limit_time = $children_limit_time ->format($date_data.$children_contract_time_B);
                                    $children_limit = strtotime($children_limit_time);
                                    if($children_date_time > $children_limit){
                                        //30分毎に計算
                                        $children_date_time_total .= "　".date('H:i:s', strtotime($item[1]['children_datetime']));
                                        $children_date .= "　".ceil(($children_date_time - $children_limit)/60/30)*500;
                                        $attend_cost_total = $attend_cost_total + ceil(($children_date_time - $children_limit)/60/30)*500;
                                    }
                                    else{
                                        $children_date_time_total .= "";
                                        $children_date .= "　";
                                    }

                                }
                            }
                            elseif(isset($item[0]['id'])){
                                if($item[0]['children_attend'] == "降園" || $item[0]['children_attend'] == "自動退勤"){
                                    $children_date_time_total = date('H:i:s', strtotime($item[0]['children_datetime']));
                                    $children_date_time = strtotime($item[0]['children_datetime']);
                                    $children_limit_time = new Datetime();
                                    $children_limit_time = $children_limit_time ->format($date_data.$children_contract_time_B);
                                    $children_limit = strtotime($children_limit_time);

                                    if($children_date_time > $children_limit){
                                        //30分毎に計算
                                        $children_date = ceil(($children_date_time - $children_limit)/60/30)*500;
                                        $attend_cost_total = $attend_cost_total + $children_date;
                                    }
                                    else{
                                        $children_date_time_total = "";
                                        $children_date = "なし";
                                    }
                                }
                            }else{$children_date = "なし"; $children_date_time_total = "";}
                        }else{$children_date = "なし"; $children_date_time_total = "";}
                        ?>
                         <div class="col-2" style="border: 1px solid">
                            <p><?php print($i);?>日</p>
                        </div>
                        <div class="col-6" style="border: 1px solid">
                            <?php if(isset($children_date_time_total)){print($children_date_time_total);}else{echo"";} ?>
                        </div>
                        <div class="col-2 text-center" style="border: 1px solid">
                            <?php print($children_date);?>
                        </div>
                    </div>
                <?php
                    if($i<$month){$attend_cost_array .= '{"date_name":"'.$i.'","children_datetime_total":"'.$children_date_time_total.'","children_date":"'.$children_date.'"},';}
                    else{$attend_cost_array .= '{"date_name":"'.$i.'","children_datetime_total":"'.$children_date_time_total.'","children_date":"'.$children_date.'"}';}
                    endfor;
                    $attend_cost_array = "[".$attend_cost_array."]";
                    $attend_cost_array_total = json_decode( $attend_cost_array, true ) ;

                ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-2 offset-8"><p>延長保育料計</p></div>
            <div class="col-2"><?php print($attend_cost_total."円");?></div>
        </div>
        <hr>
        <p class="box1">諸経費</p>
        <hr class="double">
        <div class="row">
            <div class="col-6 order-1">
                <?php 
                $data = $DB->query("SELECT item_id,item_count FROM cost_result WHERE cost_date LIKE '%".$_GET['month']."%' AND children_id = '".$children_id['children_id']."'");
                $item_data = $data->fetchAll();
                $count=$data->rowCount();
                for($i=1; $i < 8; $i++):
                    $cost_item = $DB->query("SELECT cost_id,cost_name,price from cost_info where cost_id = '".$i."'");
                    $item = $cost_item->fetch();
                    if(isset($item['cost_id'])):
                        $item_value = 0;
                        for($t=0; $t < $count; $t++){
                            if($item['cost_id'] == $item_data[$t]['item_id']){
                                $item_value = $item_value + $item_data[$t]['item_count'];
                            }
                        }
                        $item_value = $item_value * $item['price'];
                        $cost_total = $cost_total + $item_value;
                ?>
                    <div class="row">
                        <div class=col-6>
                            <?php print($item['cost_name']);?>
                        </div>
                        <div class="col-6">
                            <?php print($item_value."円");?>
                        </div>
                    </div>
                    <?php endif;?>
                <?php endfor;?>
            </div>
            <div class="col-6 order-2">
            <?php 
                $data = $DB->query("SELECT item_id,item_count FROM cost_result WHERE cost_date LIKE '%".$_GET['month']."%' AND children_id = '".$children_id['children_id']."'");
                $item_data = $data->fetchAll();
                $count=$data->rowCount();
                for($i=8; $i <= 12; $i++):
                    $cost_item = $DB->query("SELECT cost_id,cost_name,price from cost_info where cost_id = '".$i."'");
                    $item = $cost_item->fetch();
                    if(isset($item['cost_id'])):
                        $item_value = 0;
                        for($t=0; $t < $count; $t++){
                            if($item['cost_id'] == $item_data[$t]['item_id']){
                                $item_value = $item_value + $item_data[$t]['item_count'];
                            }
                        }
                        $item_value = $item_value * $item['price'];
                        $cost_total = $cost_total + $item_value;
                ?>
                    <div class="row">
                        <div class=col-6>
                            <?php print($item['cost_name']);?>
                        </div>
                        <div class="col-6">
                            <?php print($item_value."円");?>
                        </div>
                    </div>
                    <?php endif;?>
                <?php endfor;?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-2 offset-8"><p>諸経費計</p></div>
            <div class="col-2"><?php print($cost_total."円");?></div>
        </div>
        <hr>
        <p>請求合計</p>
        <hr class="double">
        <?php
            $seikyu_cost_total = $children_contract_type_total + $attend_cost_total + $cost_total + $not_payment + $seikyu_cost_total;
        ?>
        <div class="row">
            <div class="col-3 offset-1"><p><?php print($children_id['children_contract_type']);?></p></div>
            <div class="col-3 offset-5"><?php print($children_contract_type_total."円");?></div>
        </div>
        <div class="row">
            <div class="col-3 offset-1"><p>延長保育</p></div>
            <div class="col-3 offset-5"><?php print($attend_cost_total."円");?></div>
        </div>
        <div class="row">
            <div class="col-3 offset-1"><p>諸経費</p></div>
            <div class="col-3 offset-5"><?php print($cost_total."円");?></div>
        </div>
        <div class="row">
            <div class="col-3 offset-1"><p>未入金</p></div>

            <div class="col-3 offset-4"><input type="number" name="not_payment" value="0">円</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-3 offset-1"><p>請求金額</p></div>
            <div class="col-3 offset-5"><?php print($seikyu_cost_total."円");?></div>
        </div>
        <hr>
            <input type="hidden" name="type" value="children">
            <input type="hidden" name="cost_total" value="<?php print($cost_total);?>">
            <input type="hidden" name="children_contract_type_total" value="<?php print($children_contract_type_total);?>">
            <input type="hidden" name="attend_cost_total" value="<?php print($attend_cost_total);?>">

            <input type="hidden" name="seikyu_cost_total" value="<?php print($seikyu_cost_total);?>">
            <input type="hidden" name="month" value="<?php print($_GET['month']);?>">
            <input type="hidden" name="children_name" value="<?php print($_GET['children_name']);?>">
            <input type="hidden" name="print_number" value="<?php print($print_number);?>">
            <!---input type="hidden" name="attend_cost_array_total[]" value="<?php print_r($attend_cost_array_total);?>"--->
            <input type="submit" value="印刷プレビュー">
        </form>
        
    </div>
    <?php 
        $_SESSION['attend_cost_array_total'] = $attend_cost_array;
        else:?>
    <div class="container py-4 text-center">
        <h3>請求情報はありません。</h3>
    </div>
    <?php endif;?>
</body>
</html>
