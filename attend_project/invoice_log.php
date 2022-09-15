<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>諸経費利用履歴</title>
    <?php require("base_infomation.php");
            if(isset($_GET['month'])){
                $month = $_GET['month'];
                $month_item = date('Y年m月', strtotime($month));
                $month = date('t', strtotime($month));
            }else{
                $month = date('YYYY-mm');
                $month_item = "0000年00月";
                $month = date('t', strtotime($month));
            }
            if(isset($_GET['children_name'])){
                $children_name = $_GET['children_name'];
                if($children_data = $DB->query("SELECT children_id from children_info where children_name like '%".$children_name."%'")){
                    $children_id = $children_data ->fetch();
                }
                else{
                    echo"検索できませんでした";
                }
            }else{
                $item_name = "";
                echo "園児名が入力されていません。";
            }

    ?>
</head>
<body>
    <div class="container bg-dark text-white">
        <h2>諸経費利用履歴</h2>
            <form action="cost_log.php" method="get">
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
                    <input type="hidden" name="type" value="invoice">
                    <input type="submit" value="検索">
                </div>
            </div>
            </form>
    </div>
    <div class="container">
    <h1><?php print($month_item);?>分</h1>
    <h2>園児名：<?php if(isset($_GET['children_name'])){print($_GET['children_name']);}?></h2>

        <div class="row">
            <div class="col-6 order-1">
                <?php for($i=1; $i <= 15; $i++):
                    //日付の作成
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
                        $data = $DB->query("SELECT invoice_log.id,invoice_value,invoice_id,invoice_log.children_id,children_name from invoice_log left outer join children_info on invoice_log.children_id = children_info.children_id where children_info.children_id = '".$children_id['children_id']."' AND invoice_date like '%".$date_data."%'");
                        $item = $data->fetch();
                    ?>
                         <div class=col-2>
                            <p><?php print($i);?>日</p>
                        </div>
                        <div class=col-6>
                            <p>園児名</p>
                            <?php if(isset($item['invoice_date'])){print($item['children_name']."<br>");}else{print("");} ?>
                        </div>
                        <div class=col-2>
                            <p>請求額</p>
                            <?php if(isset($item['invoice_date'])){print($item['invoice_value']."<br>");}else{print("0");} ?>
                        </div>
                        <div class=col-2>
                            <a tupe="button" href="cost_update.php?type=cost&button_select=add<?php if(isset($item['id'])){print("&id=".$item['id']."&children_name=".$_GET['children_name']);}else{print("&children_name=".$_GET['children_name']."&cost_date=".$date_data);}?>">追加</a><br>
                            <a tupe="button" href="cost_update.php?type=cost&button_select=delete<?php if(isset($item['id'])){print("&id=".$item['id']."&children_name=".$_GET['children_name']."&cost_name=".$item['cost_name']."&item_count=".$item['item_count']);}?>"><?php if(isset($item['id'])){echo "削除";}else{echo "";}?></a>
                        </div>
                    </div>
                <?php endfor;?>
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
                        $data = $DB->query("SELECT invoice_log.id,invoice_value,invoice_id,invoice_log.children_id,children_name from invoice_log left outer join children_info on invoice_log.children_id = children_info.children_id where children_info.children_id = '".$children_id['children_id']."' AND invoice_date like '%".$date_data."%'");
                        $item = $data->fetch();
                    ?>
                         <div class=col-2>
                            <p><?php print($i);?>日</p>
                        </div>
                        <div class=col-6>
                            <p>園児名</p>
                            <?php if(isset($item['invoice_date'])){print($item['children_name']."<br>");}else{print("");} ?>
                        </div>
                        <div class=col-2>
                            <p>請求額</p>
                            <?php if(isset($item['invoice_date'])){print($item['invoice_value']."<br>");}else{print("0");} ?>
                        </div>
                        <div class=col-2>
                            <a tupe="button" href="cost_update.php?type=cost&button_select=add<?php if(isset($item['id'])){print("&id=".$item['id']."&children_name=".$_GET['children_name']);}else{print("&children_name=".$_GET['children_name']."&cost_date=".$date_data);}?>">追加</a><br>
                            <a tupe="button" href="cost_update.php?type=cost&button_select=delete<?php if(isset($item['id'])){print("&id=".$item['id']."&children_name=".$_GET['children_name']."&cost_name=".$item['cost_name']."&item_count=".$item['item_count']);}?>"><?php if(isset($item['id'])){echo "削除";}else{echo "";}?></a>
                        </div>
                    </div>
                <?php endfor;?>
            </div>

        </div>
    </div>
</body>
</html>