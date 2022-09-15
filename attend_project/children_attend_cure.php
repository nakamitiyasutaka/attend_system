<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require("base_infomation.php");
    if(isset($_GET['id'])){
            $data = $DB->prepare("SELECT * FROM children_attend WHERE id =?");
            $cure_data = $data->execute(array($_GET['id']));
            $cure_data = $data->fetch();
            $children_data = $DB->query("SELECT * FROM children_info WHERE children_id = '".$cure_data['children_id']."'");
            $children = $children_data->fetch();
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
                        <th>出欠種類</th>
                        <th>時間</th>
                    </tr>
                    <form action="children_attend_cure_result.php"　id="id" method="POST">
                        <tr>
                            <td><?php print($cure_data['id']);?></td>
                            <td><?php print($children['children_name']);?></td>
                            <td><?php print($cure_data['children_attend']);?></td>
                            <td><?php print($cure_data['children_datetime']);?></td>
                            <td></td>
                            <td></td>
                        </tr>
                </table>
                <h4 class="my-5">修正後情報</h4>
                <table class="table" style="table-layout:fixed;">
                        <tr>
                            <td><?php print($cure_data['id']);?></td>
                            <td><?php print($children['children_name']);?></td>
                            <td><?php print($cure_data['children_attend']);?></td>
                            <td><input type="datetime-local"name="new_children_datetime" value="YYYY-MM-dd hh:mm:ss" step="1" required></td>
                            <td>
                                <input type="hidden" name="id" value="<?php print($cure_data['id']);?>">
                                <input type="hidden" name="children_attend" value="<?php print($cure_data['children_attend']);?>">
                            </td>
                            <td>
                                <button  class="btn btn-info" type="submit" onClick="return Check1()" name="cure" value="<?php print($button_name)?>"><?php print($button_name)?></button>
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
                        <th>出欠種類</th>
                        <th>時間</th>
                    </tr>
                    <form action="children_attend_remove_result.php" id="id" method="POST">
                        <tr>
                            <td><?php print($cure_data['id']);?></td>
                            <td><?php print($children['children_name']);?></td>
                            <td><?php print($cure_data['children_attend']);?></td>
                            <td><?php print($cure_data['children_datetime']);?></td>
                            <td>
                                <input type="hidden" name="id" value="<?php print($cure_data['id']);?>">
                                <input type="hidden"name="new_children_datetime" value="<?php print($cure_data['children_datetime']);?>">
                                <button class="btn btn-info" onClick="return Check2()" type="submit" name="cure" value="<?php print($button_name)?>"><?php print($button_name)?></button>
                            </td>
                        </tr>
                    </form>
                </table>
            <?php endif;?>
            <?php if(isset($_GET['new'])):?>
            <?php if(isset($_GET['children_name'])){
                $data = $DB->prepare("SELECT children_id FROM children_info WHERE children_name =?");
                $cure_data = $data->execute(array($_GET['children_name']));
                $cure_data = $data->fetch();
                $DB->exec("INSERT INTO children_attend(children_id,children_attend,children_datetime)VALUES('".$cure_data['children_id']."','".$_GET['children_attend']."','".$_GET['new_children_datetime']."')");
                $date = new DateTime($_GET['new_children_datetime']);
            }

            ?>
            <table class="table" style="table-layout:fixed;">
                    <tr>
                        <th>名前</th>
                        <th>出欠種類</th>
                        <th>時間</th>
                    </tr>
                    <form action="children_attend_cure.php"method="get">
                        <tr>
                            <td><input type="text" name = "children_name" value="なまえ" require></td>
                            <td>登園　<input type="radio" name = "children_attend" value="登園" require>　降園　<input type="radio" name = "children_attend" value="降園"></td>
                            <td><input type="datetime-local"name="new_children_datetime" value="YYYY-MM-dd hh:mm:ss" step="1" required></td>
                            <td><button  class="btn btn-info" type="submit" onClick="return Check3()" name="new" value="新規追加">新規追加</button></td>
                        </tr>
                </table>
            <?php endif; if(isset($_GET['children_name'])){print("新規追加されました。 (".$_GET['children_name']."　　".$date->format('Y年m月d日 H:i:s')."　　".$_GET['children_attend'].")");}?>
            <br>
            <p class="text-right"><a class="btn btn-danger text-white" href="children_attend_update.php">戻る</a></p>

    </div>
</body>
</html>