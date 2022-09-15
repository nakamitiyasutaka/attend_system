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
        <p>
            <?php
                if($_GET['button_select'] == "add" && $insert = $DB->exec
                ("INSERT INTO cost_result(children_id,cost_date,item_id,item_count)
                VALUES('".$_GET['children_id']."','".$_GET['cost_date']."','".$_GET['item_id']."','".$_GET['item_count']."') ")){
                    echo"項目を追加しました。";
                    print($_GET['cost_date']);
                }
                    if($_GET['button_select'] == "delete" && $insert = $DB->exec("DELETE FROM cost_result WHERE id='".$_GET['id']."'")){
                    echo"項目を削除しました。";
                }
            ?>
        </p>
        <a type="button" href="cost_log.php?month=&children_name=&type=cost">戻る</a>
    </div>
</body>
</html>