<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require("base_infomation.php");
        
        $id = $_GET['id'];
        $new_staff_datetime = date('Y-m-d',strtotime($_GET['new_'.$type.'_datetime']));

    ?>

    <title>タイムカード編集画面</title>
</head>
<body>
    <div class="container">
        <h3 class="m-4"> <?php print($_GET['cure']);?>されました。</h3>
        <?php $DB->exec("DELETE FROM ".$type."_attend WHERE id='".$id."'");?>
        <form action="attend_update.php" method="get">
            <input type="hidden" name="<?php print($type);?>_datetime" value="<?php print($new_staff_datetime);?>">
            <input type="hidden" name="type" value="<?php print($type);?>">
            <button class="btn btn-success" type="submit">戻る</button>
        </form>
    </div>
</body>
</html>