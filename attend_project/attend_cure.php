<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タイムカード編集画面</title>
    <?php
    require("base_infomation.php");

    if(isset($_GET['id'])){
        $job_id = $_GET['id'];
        $data = $DB->prepare("SELECT * FROM ".$type."_attend WHERE id =?");
        $cure_data = $data->execute(array($_GET['id']));
	$cure_data = $data->fetch();
        $staff_data = $DB->query("SELECT * FROM ".$type."_info WHERE ".$type."_id = ".$cure_data[$type.'_id']."");
        $staff = $staff_data->fetch();
        $button_name=$_GET['button_name'];
        }
        else{
            $button_name=$_GET['new'];
        }
    ?>
</head>
<body>
    <div class="py-4 bg-dark text-white container">
        <h2 class="p-4"><?php print($button_name)?>ページ</h2>
    </div>
    <div class="container">
            <?php if($button_name == "修正"):?>
                <h4 class="my-5">修正前情報</h4>
                <table class="table" style="table-layout:fixed;">
                    <tr>
                        <th>id</th>
                        <th>名前</th>
                        <th>出勤内容</th>
                        <th>時間</th>
                    </tr>
                    <form action="attend_cure_result.php" id=id method="GET">
                        <tr>
                            <td><?php print($cure_data['id']);?></td>
                            <td><?php print($staff[$type.'_name']);?></td>
                            <td><?php print($cure_data[$type.'_attend']);?></td>
                            <td><?php print($cure_data[$type.'_datetime']);?></td>
                            <td></td>
                            <td></td>
                        </tr>
                </table>
                <h4 class="my-5">修正後情報</h4>
                <table class="table" style="table-layout:fixed;">
                        <tr>
                            <td><?php print($cure_data['id']);?></td>
                            <td><?php print($staff[$type.'_name']);?></td>
                            <td><?php print($cure_data[$type.'_attend']);?></td>
                            <td><input type="datetime-local"name="new_<?php print($type);?>_datetime" id="today" value="YYYY-MM-dd hh:mm:ss" step="1" required></td>
                            <td>
                                <input type="hidden" name="id" value="<?php print($cure_data['id']);?>">
                                <input type="hidden" name="<?php print($type);?>_attend" value="<?php print($cure_data[''.$type.'_attend']);?>">
                                <input type="hidden" name="type" value="<?php print($type);?>">
                            </td>
                            <td>
                                <button  class="btn btn-success" type="submit" onClick="return Check1()" name="cure" value="<?php print($button_name)?>"><?php print($button_name)?></button>
                            </td>
                        </tr>
                    </form>
                </table>
            <?php endif;?>
            <?php if($button_name == "削除"):?>
                <h4 class="my-5">削除情報</h4>
                <table class="my-5 table" style="table-layout:fixed;">
                    <tr>
                        <th>id</th>
                        <th>名前</th>
                        <th>出勤内容</th>
                        <th>時間</th>
                    </tr>
                    <form action="attend_remove_result.php" id=id method="GET">
                        <tr>
                            <td><?php print($cure_data['id']);?></td>
                            <td><?php print($staff[$type.'_name']);?></td>
                            <td><?php print($cure_data[$type.'_attend']);?></td>
                            <td><?php print($cure_data[$type.'_datetime']);?></td>
                            <td>
                                <input type="hidden" name="id" value="<?php print($cure_data['id']);?>">
                                <input type="hidden"name="new_<?php print($type);?>_datetime" value="<?php print($cure_data[$type.'_datetime']);?>">
                                <input type="hidden" name="type" value="<?php print($type);?>">
                                <button class="btn btn-success" onClick="return Check2()" type="submit" name="cure" value="<?php print($button_name)?>"><?php print($button_name)?></button>
                            </td>
                        </tr>
                    </form>
                </table>
            <?php endif;?>
            <!----------------------新規追加ページ----------------------------->
            <?php if(isset($_GET['new'])):?>
            <?php 
                if(isset($_GET[$type.'_name'])){
                $data = $DB->prepare("SELECT ".$type."_id FROM ".$type."_info WHERE ".$type."_name =?");
                $cure_data = $data->execute(array($_GET[$type.'_name']));
                $cure_data = $data->fetch();
                $DB->exec("INSERT INTO ".$type."_attend(".$type."_id,".$type."_attend,".$type."_datetime)VALUES('".$cure_data[''.$type.'_id']."','".$_GET[$type.'_attend']."','".$_GET['new_'.$type.'_datetime']."')");
                $date = new DateTime($_GET['new_'.$type.'_datetime']);}

            ?>
            <table class="table" style="table-layout:fixed;">
                    <tr>
                        <th>名前</th>
                        <th>出欠種類</th>
                        <th>時間</th>
                    </tr>
                    <form action="attend_cure.php"method="get">
                        <tr>
                            <td><input type="text" name = "<?php print($type);?>_name" value="なまえ" require></td>
                            <td><?php print($attend_column[0]);?>　<input type="radio" name = "<?php print($type);?>_attend" value="<?php print($attend_column[0]);?>" require>　<?php print($attend_column[1]);?>　<input type="radio" name = "<?php print($type);?>_attend" value="<?php print($attend_column[1]);?>"></td>
                            <td><input type="datetime-local"name="new_<?php print($type);?>_datetime" value="YYYY-MM-dd hh:mm:ss" step="1" required></td>
                            <td><button  class="btn btn-success" type="submit" onClick="return Check3()" name="new" value="新規追加">新規追加</button></td>
                        </tr>
                        <input type="hidden" name="type" value="<?php print($type);?>">
                    </form>
                </table>
            <?php endif; if(isset($_GET[$type.'_name'])){print("新規追加されました。 (".$_GET[$type.'_name']."　　".$date->format('Y年m月d日 H:i:s')."　　".$_GET[$type.'_attend'].")");}?>
            <br>
            <p class="text-right"><a class="btn btn-primary text-white" href="attend_update.php?type=<?php print($type);?>">戻る</a></p>


    </div>
</body>
</html>
