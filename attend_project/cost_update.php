<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("base_infomation.php");?>
    <title>諸経費項目修正</title>
</head>
<body>
    <div class="container">
        <?php if($_GET['button_select'] == "add"):?>
        <h1>追加画面</h1>
            <p><?php 
                if(isset($_GET['id'])){
                    if($item_data = $DB->query("SELECT cost_date,children_name,cost_result.children_id from cost_result left outer join children_info on cost_result.children_id = children_info.children_id  where cost_result.id = '".$_GET['id']."'")){
                    $item = $item_data ->fetch();
                    }else{echo"検索できませんでした。";}
                }
                else{
                    if($children_data = $DB->query("SELECT children_id from children_info where children_name LIKE '%".$_GET['children_name']."%'")){
                        $children = $children_data ->fetch();
                    }else{echo"検索できませんでした。";}
                }
            ?></p>
            <form action="cost_update_result.php" method="GET">
                <div class="row">
                    <div class="col-2">
                        <p>日付</p>
                        <p><?php if(isset($_GET['id'])){print($item['cost_date']);}else{print($_GET['cost_date']);}?></p>
                        <input type="hidden" name="cost_date" value="<?php if(isset($_GET['id'])){print($item['cost_date']);}else{print($_GET['cost_date']);}?>">
                    </div>
                    <div class="col-2">
                        <p>園児名</p>
                        <p><?php if(isset($_GET['id'])){print($item['children_name']);}else{print($_GET['children_name']);}?></p>
                        <input type="hidden" name="children_id" value="<?php print($children['children_id']);?>">
                    </div>
                    <div class="col-4">
                        <p>アイテム名</p>
                        <?php
                            $radio_data = $DB->query("SELECT cost_name,cost_id from cost_info");
                            while($radio_name = $radio_data ->fetch()):
                        ?>
                        <p><input type="radio" name="item_id" value="<?php print($radio_name['cost_id']);?>"><?php print($radio_name['cost_name']);?></p>
                        <?php endwhile;?>
                    </div>
                    <div class="col-2">
                        <p>個数</p>
                        <input type="number" name="item_count" min=0 value="1">
                    </div>
                    <div class="col-2">
                        <input type="hidden" name="children_name" value="<?php print($_GET['children_name']);?>">
                        <input type="hidden" name="button_select" value="add">
                        <input type="hidden" name="type" value="cost">
                        <input type="submit" name="insert" value="追加">
                    </div>
                </div>
            </form>
            <a type="button" href="cost_log.php?month=&children_name=&type=cost">戻る</a>
        <?php endif;?>
        <?php
            if($_GET['button_select'] == "delete"):
                if($item_data = $DB->query("SELECT cost_date,children_name,cost_result.children_id from cost_result left outer join children_info on cost_result.children_id = children_info.children_id  where cost_result.id = '".$_GET['id']."'")){
                    $item = $item_data ->fetch();
                }else{echo"検索できませんでした。";}
        ?>
        <h1>削除画面</h1>
        <div class="row">
                <div class="col-2">
                    <p>日付</p>
                    <p><?php print($item['cost_date']);?></p>
                </div>
                <div class="col-2">
                    <p>園児名</p>
                    <p><?php print($item['children_name']);?></p>
                </div>
                <div class="col-4">
                    <p>アイテム名</p>
                    <p><?php print($_GET['cost_name']);?></p>
                </div>
                <div class="col-2">
                    <p>個数</p>
                    <p><?php print($_GET['item_count']);?></p>
                </div>
                <div class="col-2">
                    <a type="button" href="cost_update_result.php?type=cost&button_select=delete&id=<?php print($_GET['id']);?>">削除</a>
                </div>
        </div>
        <a type="button" href="cost_log.php?month=&children_name=&type=cost">戻る</a>
        <?php endif;?>
    </div>
</body>
</html>