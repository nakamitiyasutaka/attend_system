<!DOCTYPE html>
<html lang="ja">
<head>
    <?php 
        require("base_infomation.php");
        ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Document</title>
    <?php
        if(isset($_GET['delete'])){
            $page = $_GET['delete'];
        }elseif(isset($_GET['edit'])){
            $page = $_GET['edit'];
        }elseif(isset($_GET['detail'])){
            $page = $_GET['detail'];
        }
    ?>
</head>
<html>
    <body>
<!------修正画面------->

        <?php if(!isset($_GET['cure'])):
                if(!isset($_GET['new'])):
                if(isset($_GET['edit'])):
                $data = $DB->query("SELECT * FROM children_info WHERE children_id = '".$_GET['children_id']."'");
                $children = $data->fetch();
                $children_family = json_decode( $children['children_family'] , true ) ; //家族情報をjson形式から変換
                $array_count = count($children_family);

                $today = date("Y-m-d");
                $age = floor(((strtotime($today) - strtotime($children['children_birthday'])) / 86400/365)).'さい';
                ?>

            <div class="container bg-info text-white py-5 px-4">
                <h1 ><?php print($page);?></h1>
            </div>
            <div class="container bg-light py-5 px-4">
                <div class="form-group">
                    <form action="children_info_cure.php" method="GET">
                        <h2 class="p-2">園児情報</h2>

                        <div class="row">
                            <div class="col-6">
                                <label for="children_id">園児id</label>
                                <input type="text" name="children_id" value="<?php print($children['children_id']);?>" readonly><br>
                                <label for="children_name">園児名</label>
                                <input type="text" name="children_name" value="<?php print($children['children_name']);?>"><br>
                                <label for="children_name_kana">カタカナ</label>
                                <input type="text" name="children_name_kana" value="<?php print($children['children_name_kana']);?>"><br>
                                <label for="children_birthday">生年月日</label>
                                <input type="date" name="children_birthday" value="<?php print($children['children_birthday']);?>"><br>
                                <p>年齢　：　<?php print($age);?></p>
                            </div>
                            <div class="col-6">
                                <label for="children_address">住所</label>
                                <input type="text" name="children_address" value="<?php print($children['children_address']);?>"><br>
                                <label>負担階層</label>
                                <select id="test_model" name="decrease_tax" onchange="flight()">
                                    <option value="0">選択してください</option>
                                    <option value="1">第1階層</option>
                                    <option value="2">第2階層</option>
                                    <option value="3">第3階層</option>
                                    <option value="4">第4階層</option>
                                    <option value="5">第5階層</option>
                                    <option value="6">第6階層</option>
                                    <option value="7">第7階層</option>
                                    <option value="8">第8階層</option>
                                    <option value="9">第9階層</option>
                                    <option value="10">第10階層</option>
                                    <option value="11">第11階層</option>
                                </select>
                                <p id="call"><label for="decrease_tax">多子軽減</label>　全額<input type="radio" name="decrease_tax" value="0" checked="checked">　　半額<input type="radio" name="decrease_tax" value="1">
                                <div id = "message_area"></div>
                                <p class="<?php if($cildren['children_contract_type'] == "短縮保育"){echo "text-danger";}?>">現在の登録されている状態　：　<?php print($children['children_contract_type']);?></p>
                                <label for="children_contract_type">通常保育</label>
                                <input type="radio" name="children_contract_type" value="通常保育" checked="checked">
                                <label for="children_contract_type">短縮保育</label>
                                <input type="radio" name="children_contract_type" value="短縮保育"><br>

                                <script language="javascript" type="text/javascript">
                                    function flight(){
                                        var test_model = document.getElementById("test_model").value;
                                        var message ="";
                                        if(test_model < 6){
                                            message = "多子軽減額は、<?php print($children['decrease_tax']);?>です。";
                                            document.getElementById("call").style.display="block";

                                        }
                                        if(test_model == 6){
                                            message = "第6階層の場合は、半額でなく9000円です。";
                                            document.getElementById("call").style.display="block";

                                        }
                                        if(test_model > 6){
                                            message = "多子軽減はありません";
                                            document.getElementById("call").style.display="none";

                                        }
                                        document.getElementById("message_area").innerHTML = message;
                                    }
                                </script>



                            </div>
                        </div>
                    </div>
                    <div class="container bg-info py-5 px-4">
                    <h2 class="p-2">保護者情報</h2>
                    <div class="row">
                                <?php for($i=0 ; $i<$array_count ; $i++):?>
                                    <div class="bg-light m-4 py-2 col-3">
                                        <label for="children_family">保護者名</label><br>
                                        <input type="text" name="children_family_<?php print($i);?>" value="<?php print($children_family[$i]['name']);?>"><br>
                                        <label for="children_family_kana">カタカナ</label><br>
                                        <input type="text" name="children_family_kana_<?php print($i);?>" value="<?php print($children_family[$i]['name_kana']);?>"><br>
                                        <label for="family_relationship">続柄</label><br>
                                        <input type="text" name="family_relationship_<?php print($i);?>" value="<?php print($children_family[$i]['relation']);?>"><br>
                                        <label for="family_TEL">連絡先</label><br>
                                        <input type="text" name="family_TEL_<?php print($i);?>" value="<?php print($children_family[$i]['TEL']);?>">
                                    </div>
                                <?php endfor;?>
                    </div>
                        <input type="hidden" name="count" value="<?php print($array_count);?>">
                        <input type="hidden" name="type" value="children">
                        <button class="btn btn-warning" type="submit" name="cure" value="<?php print($page);?>" onClick="return Check1()"><?php print($page);?></button>
                    </form>
                    <form action="staff_info.php" method="GET">
                        <input type="hidden" name="type" value="children">
                        <button class="btn btn-warning my-2" type="submit">戻る</button>
                    </form>
                </div>
            </div>
            <?php endif;?>

            <?php if(isset($_GET['detail'])):
            //---------------------------詳細ページ------------------------------------------

                $data = $DB->query("SELECT * FROM children_info WHERE children_id = '".$_GET['children_id']."'");
                $children = $data->fetch();
                $children_family = json_decode( $children['children_family'] , true ) ; //家族情報をjson形式から変換
                $array_count = count($children_family);
                $today = date("Y-m-d");
                $age = floor(((strtotime($today) - strtotime($children['children_birthday'])) / 86400/365)).'歳';
                ?>

            <div class="container bg-info text-white py-5 px-4">
                <h1><?php print($page);?></h1>
            </div>
            <div class="container bg-light py-5 px-4">
                <div class="form-group">
                    <form action="children_info_cure.php" method="GET">
                        <h2 class="p-2">園児情報</h2>
                        <div class="row">
                            <div class="col-6">
                                <h5 class="bg-info text-white p-1">園児id</h4>
                                <p class="px-2"><?php print($children['children_id']);?></p>
                                <h5 class="bg-info text-white p-1">園児名</h5>
                                <p class="px-2"><?php print($children['children_name']);?></p>
                                <h5 class="bg-info text-white p-1">カタカナ</h5>
                                <p class="px-2"><?php print($children['children_name_kana']);?></p>
                                <h5 class="bg-info text-white p-1">生年月日</h5>
                                <p class="px-2"><?php print($children['children_birthday']);?></p>
                                <p class="px-2">年齢　：　<?php print($age);?></p>
                            </div>
                            <div class="col-6">
                                <h5 class="bg-info text-white p-1">負担階層</h5>
                                <p class="px-2"><?php print("第　".$children['family_level']."　階層");?></p>
                                <h5 class="bg-info text-white p-1">多子軽減</h5>
                                <p class="px-2"><?php print($children['decrease_tax']);?></p>
                                <h5 class="bg-info text-white p-1">保育形態</h5>
                                <p class="<?php if($cildren['children_contract_type'] == "短縮保育"){echo "text-danger";}?> px-2">現在の状態　：　<?php print($children['children_contract_type']);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="container bg-info py-5 px-4">
                    <h2 class="p-2">保護者情報</h2>
                    <div class="row">
                                <?php for($i=0 ; $i < $array_count; $i++):?>
                                    <div class="bg-light m-4 py-2 col-3">
                                        <h5 class="bg-info text-white p-1">保護者名</h5>
                                        <p class="px-2"><?php print($children_family[$i]['name']);?></p>
                                        <h5 class="bg-info text-white p-1">カタカナ</h5>
                                        <p class="px-2"><?php print($children_family[$i]['name_kana']);?></p>
                                        <h5 class="bg-info text-white p-1">続柄</h5>
                                        <p class="px-2"><?php print($children_family[$i]['relation']);?></p>
                                        <h5 class="bg-info text-white p-1">連絡先</h5>
                                        <p class="px-2"><?php print($children_family[$i]['TEL']);?></p>
                                    </div>
                                <?php endfor;?>
                    </div>
                    </form>
                    <form action="staff_info.php" method="GET">
                        <input type="hidden" name="type" value="children">
                        <button class="btn btn-warning my-2" type="submit">戻る</button>
                    </form>
                </div>

            <?php endif;?>
            <?php if(isset($_GET['delete'])):
            //-----------削除ページ------------------------------------------
                $data = $DB->query("SELECT * FROM children_info WHERE children_id = '".$_GET['children_id']."'");
                $children = $data->fetch();
                $children_family = json_decode( $children['children_family'] , true ) ; //家族情報をjson形式から変換
                $array_count = count($children_family);
                $today = date("Y-m-d");
                $age = floor(((strtotime($today) - strtotime($children['children_birthday'])) / 86400/365)).'歳';
                ?>

            <div class="container bg-info text-white py-5 px-4">
                <h1><?php print($page);?></h1>
            </div>
            <div class="container bg-light py-5 px-4">
                <div class="form-group">
                    <form action="children_info_cure.php" method="GET">
                        <h2 class="p-2">園児情報</h2>
                        <div class="row">
                            <div class="col-6">
                                <h5 class="bg-info text-white p-1">園児id</h4>
                                <p class="px-2"><?php print($children['children_id']);?></p>
                                <h5 class="bg-info text-white p-1">園児名</h5>
                                <p class="px-2"><?php print($children['children_name']);?></p>
                                <h5 class="bg-info text-white p-1">カタカナ</h5>
                                <p class="px-2"><?php print($children['children_name_kana']);?></p>
                                <h5 class="bg-info text-white p-1">生年月日</h5>
                                <p class="px-2"><?php print($children['children_birthday']);?></p>
                                <p class="px-2">年齢　：　<?php print($age);?></p>
                            </div>
                            <div class="col-6">
                                <h5 class="bg-info text-white p-1">住所</h5>
                                <p class="px-2"><?php print($children['children_address']);?></p>
                                <h5 class="bg-info text-white p-1">負担階層</h5>
                                <p class="px-2"><?php print("第".$children['family_level']."階層");?></p>
                                <h5 class="bg-info text-white p-1">多子軽減</h5>
                                <p class="px-2"><?php print($children['decrease_tax']."円");?></p>
                                <h5 class="bg-info text-white p-1">保育形態</h5>
                                <p class="<?php if($cildren['children_contract_type'] == "短縮保育"){echo "text-danger";}?> px-2">現在の状態　：　<?php print($children['children_contract_type']);?></p>
                            </div>
                        </div>
                    </div>
                    <div class="container bg-info py-5 px-4">
                    <h2 class="p-2">保護者情報</h2>
                    <div class="row">
                                <?php for($i=0 ; $i<$array_count ; $i++):?>
                                    <div class="bg-light m-4 py-2 col-3">
                                        <h5 class="bg-info text-white p-1">保護者名</h5>
                                        <p class="px-2"><?php print($children_family[$i]['name']);?></p>
                                        <h5 class="bg-info text-white p-1">カタカナ</h5>
                                        <p class="px-2"><?php print($children_family[$i]['name_kana']);?></p>
                                        <h5 class="bg-info text-white p-1">続柄</h5>
                                        <p class="px-2"><?php print($children_family[$i]['relation']);?></p>
                                        <h5 class="bg-info text-white p-1">連絡先</h5>
                                        <p class="px-2"><?php print($children_family[$i]['TEL']);?></p>
                                    </div>
                                <?php endfor;?>
                    </div>
                        <input type="hidden" name="count" value="<?php print($n);?>">
                        <input type="hidden" name="type" value="children">
                        <input type="hidden" name="children_id" value="<?php print($_GET['children_id'])?>">
                        <button class="btn btn-warning" type="submit" name="cure" value="<?php print($page);?>" onClick="return Check2()"><?php print($page);?></button>
                    </form>
                    <form action="staff_info.php" method="GET">
                        <input type="hidden" name="type" value="children">
                        <button class="btn btn-warning my-2" type="submit">戻る</button>
                    </form>
                </div>

            <?php endif;
            //----------新規登録ページ----------
                    else:
                if(isset($_GET['entry'])){
                    $n=$_GET['count'];
                    $children_family;
                    $children_family = '{"name":"'.$_GET['children_family_0'].'","name_kana":"'.$_GET['children_family_kana_0'].'","relation":"'.$_GET['family_relationship_0'].'","TEL":"'.$_GET['family_TEL_0'].'"}';
                    for($i=1;$i<$n;$i++){
                            $children_family .= ',{"name":"'.$_GET['children_family_'.$i].'","name_kana":"'.$_GET['children_family_kana_'.$i].'","relation":"'.$_GET['family_relationship_'.$i].'","TEL":"'.$_GET['family_TEL_'.$i].'"}';
                    }
                    $children_family = "[".$children_family."]";
                    print($children_family);

                        if($DB->exec("INSERT INTO children_info (
                        children_contract_type,
                        family_level,
                        decrease_tax,
                        children_name_kana,
                        children_name,
                        children_birthday,
                        children_address,
                        children_family
                        )
                     VALUES(
                        '".$_GET['children_contract_type']."',
                        '".$_GET['family_level']."',
                        '".$_GET['decrease_tax']."',
                        '".$_GET['children_name_kana']."',
                        '".$_GET['children_name']."',
                        '".$_GET['children_birthday']."',
                        '".$_GET['children_address']."',
                        '".$children_family."'
                        )")){echo"登録完了しました。";}else{echo"登録できませんでした。";}
                }

            ?>

                <div class="container bg-info text-white py-5 px-4">
                <h1>新規登録</h1>
            </div>
            <div class="container bg-light py-5 px-4">
                <div class="form-group">
                    <form action="children_info_cure.php" id="form_1" method="GET"></form>
                    <form action="children_info_cure.php" id="form_2" method="GET"></form>
                        <h2 class="p-2">園児情報</h2>
                        <div class="row">
                            <div class="col-6">
                                <label for="children_name">園児名</label>
                                <input type="text" form="form_1" name="children_name" value="<?php if(isset($_GET['children_name'])){print($_GET['children_name']);}else{echo"";}?>"><br>
                                <label for="children_name_kana">カタカナ</label>
                                <input type="text" form="form_1" name="children_name_kana" value="<?php if(isset($_GET['children_name_kana'])){print($_GET['children_name_kana']);}else{echo"";}?>"><br>
                                <label for="children_birthday">生年月日</label>
                                <input type="date" form="form_1" name="children_birthday" value="<?php if(isset($_GET['children_birthday'])){print($_GET['children_birthday']);}else{echo"";}?>"><br>
                            </div>
                            <div class="col-6">
                                <label for="children_address">住所</label>
                                <input type="text" form="form_1" name="children_address" value="<?php if(!isset($_GET['children_address'])){ echo"";}else{ print($_GET['children_address']);}?>"><br>
                                <select id="test_model" name="decrease_tax" onchange="flight()">
                                    <option value="0">選択してください</option>
                                    <option value="1">第1階層</option>
                                    <option value="2">第2階層</option>
                                    <option value="3">第3階層</option>
                                    <option value="4">第4階層</option>
                                    <option value="5">第5階層</option>
                                    <option value="6">第6階層</option>
                                    <option value="7">第7階層</option>
                                    <option value="8">第8階層</option>
                                    <option value="9">第9階層</option>
                                    <option value="10">第10階層</option>
                                    <option value="11">第11階層</option>
                                </select>
                                <p id="call"><label for="decrease_tax">多子軽減</label>　全額<input type="radio" name="decrease_tax" value="0" checked="checked">　　半額<input type="radio" name="decrease_tax" value="1">
                                <div id="message_area"></div>
                                <p>保育形態　<label for="children_contract_type">通常保育</label>
                                <input type="radio" form="form_1" name="children_contract_type" value="通常保育" checked="checked">
                                <label for="children_contract_type">短縮保育</label>
                                <input type="radio" form="form_1" name="children_contract_type" value="短縮保育"></p><br>
                            </div>
                        </div>
                    </div>
                    <div class="container bg-info py-5 px-4">
                    <script language="javascript" type="text/javascript">
                                    function flight(){
                                        var test_model = document.getElementById("test_model").value;
                                        var message ="";
                                        if(test_model < 6){
                                            document.getElementById("call").style.display="block";

                                        }
                                        if(test_model == 6){
                                            message = "※第6階層の場合は、半額でなく9000円です。";
                                            document.getElementById("call").style.display="block";

                                        }
                                        if(test_model > 6){
                                            message = "※第7階層以上は、多子軽減はありません";
                                            document.getElementById("call").style.display="none";

                                        }
                                        document.getElementById("message_area").innerHTML = message;
                                    }
                                </script>
                    <h2 class="p-2">保護者情報</h2>
                    <!-------form_2 に入れる内容-------->
                            <input type="number" name="family_count" form="form_2" value="<?php if(isset($_GET['family_count'])){print($_GET['family_count']);}else{echo"1";}?>" min=1 max=10>
                            <input type="hidden" form="form_2" name="children_name" value="<?php if(isset($_GET['children_name'])){print($_GET['children_name']);}else{echo"";}?>"required>
                            <input type="hidden" form="form_2" name="children_name_kana" value="<?php if(isset($_GET['children_name_kana'])){print($_GET['children_name_kana']);}else{echo"";}?>">
                            <input type="hidden" form="form_2" name="children_birthday" value="<?php if(isset($_GET['children_birthday'])){print($_GET['children_birthday']);}else{echo"";}?>"required>
                            <?php
                                if(isset($_GET['family_count'])){
                                    $n = $_GET['family_count'];
                                }else{
                                    $n = 1;
                                }
                                for($i=0 ; $i<$n ; $i++):?>
                                        <input type="hidden" form="form_2" name="children_family_<?php print($i);?>" value="<?php if(!isset($_GET['children_family_'.$i])){ echo"";}else{ print($_GET['children_family_'.$i]);}?>"required>
                                        <input type="hidden" form="form_2" name="children_family_kana_<?php print($i);?>" value="<?php if(!isset($_GET['children_family_kana_'.$i])){ echo"";}else{ print($_GET['children_family_kana_'.$i]);}?>">
                                        <input type="hidden" form="form_2" name="family_relationship_<?php print($i);?>" value="<?php if(!isset($_GET['family_relationship_'.$i])){ echo"";}else{ print($_GET['family_relationship_'.$i]);}?>">
                                        <input type="hidden" form="form_2" name="family_TEL_<?php print($i);?>" value="<?php if(!isset($_GET['family_TEL_'.$i])){ echo"";}else{ print($_GET['family_TEL_'.$i]);}?>"required>
                                        <input type="hidden" form="form_2" name="type" value="children">
                                <?php endfor;?>
                            <button class="btn btn-warning" type="submit" name="new" form="form_2" valie="新規登録">人数を増やす</button>
                    <!------------------------------------->

                    <div class="row">
                                <?php
                                if(isset($_GET['family_count'])){
                                    $n = $_GET['family_count'];
                                }else{
                                    $n = 1;
                                }

                                 for($i=0 ; $i<$n ; $i++):?>
                                    <div class="bg-light m-4 py-2 col-3">
                                        <label for="children_family">保護者名</label><br>
                                        <input type="text" form="form_1" name="children_family_<?php print($i);?>" value="<?php if(!isset($_GET['children_family_'.$i])){ echo"";}else{ print($_GET['children_family_'.$i]);}?>" required><br>
                                        <label for="children_family_kana">カタカナ</label><br>
                                        <input type="text" form="form_1" name="children_family_kana_<?php print($i);?>" value="<?php if(!isset($_GET['children_family_kana_'.$i])){ echo"";}else{ print($_GET['children_family_kana_'.$i]);}?>"><br>
                                        <label for="family_relationship">続柄</label><br>
                                        <input type="text" form="form_1" name="family_relationship_<?php print($i);?>" value="<?php if(!isset($_GET['family_relationship_'.$i])){ echo"";}else{ print($_GET['family_relationship_'.$i]);}?>"><br>
                                        <label for="family_TEL">連絡先</label><br>
                                        <input type="text" form="form_1" name="family_TEL_<?php print($i);?>" value="<?php if(!isset($_GET['family_TEL_'.$i])){ echo"";}else{ print($_GET['family_TEL_'.$i]);}?>"required><br>
                                    </div>
                                <?php endfor;?>
                    </div>
                        <input type="hidden" name="count" form="form_1" value="<?php print($n);?>">
                        <input type="hidden" name="type" form="form_1" value="children">
                        <input type="hidden" name="new" form="form_1" value="新規登録">
                        <button class="btn btn-warning " type="submit" name="entry" form="form_1" value="登録" onClick="return Check3()">新規登録</button>
                    <form action="staff_info.php" method="GET">
                        <input type="hidden" name="type" value="children">
                        <button class="btn btn-warning my-2" type="submit">戻る</button>
                    </form>
                </div>
            </div>
            <?php endif;?>
        <?php endif;?>


<!------修正・削除ボタン押下後の処理----->

        <?php if(isset($_GET['cure'])):?>
        <!-----------------------削除処理の内容----------------------------->
            <?php if($_GET['cure']=="情報削除"){
                $DB->exec("DELETE FROM children_info WHERE children_id ='".$_GET['children_id']."'");
                $link = "staff_info.php?type=children";
                $message = "削除しました";
            }
        /*-----------------------修正処理の内容-----------------------------*/
            else{
                $decrease_tax;

                $n=$_GET['count'];
                $children_family;
                $children_family = '{"name":"'.$_GET['children_family_0'].'","name_kana":"'.$_GET['children_family_kana_0'].'","relation":"'.$_GET['family_relationship_0'].'","TEL":"'.$_GET['family_TEL_0'].'"}';
                for($i=1;$i<$n;$i++){
                        $children_family .= ',{"name":"'.$_GET['children_family_'.$i].'","name_kana":"'.$_GET['children_family_kana_'.$i].'","relation":"'.$_GET['family_relationship_'.$i].'","TEL":"'.$_GET['family_TEL_'.$i].'"}';
                }
                $children_family = "[".$children_family."]";
                if($DB->exec("UPDATE children_info SET
                        children_contract_type = '".$_GET['children_contract_type']."',
                        family_level = '".$_GET['family_level']."',
                        decrease_tax = '".$decrease_tax."',
                        children_name = '".$_GET['children_name']."',
                        children_name_kana = '".$_GET['children_name_kana']."',
                        children_birthday = '".$_GET['children_birthday']."',
                        children_address = '".$_GET['children_address']."',
                        children_family = '".$children_family."'
                        WHERE children_id = '".$_GET['children_id']."'")){

                            $link = "children_info_cure.php?children_id=".$_GET['children_id']."&edit=情報修正&type=children";
                            $message = "修正しました";

                        }else{
                            $link = "children_info_cure.php?children_id=".$_GET['children_id']."&edit=情報修正&type=children";
                            $message = "修正エラー";
                        }

            }
            ?>
        <div class="container bg-info py-5 px-4">
        <h1>園児情報修正</h1>
        </div>
        <div class="container">
            <p><?php print($message);?></p>
            <a class="btn btn-warning" href="<?php print($link);?>">戻る</a>
        </div>
    <?php endif;?>
    </body>
</html>
