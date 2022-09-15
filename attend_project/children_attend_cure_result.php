<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require("base_infomation.php");

        $id = $_POST['id'];
        $children_attend = $_POST['children_attend'];
        $new_children_datetime = $_POST['new_children_datetime'];

    ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <div class="container">
        <h3 class="m-4"><?php print($_POST['cure']);?>されました。</h3>
        <?php $DB->exec("UPDATE children_attend SET children_attend='".$children_attend."',children_datetime ='".$new_children_datetime."' WHERE id ='".$id."'");?>
        <form action="children_attend_update.php" method="get">
            <?php $new_children_datetime = date('Y-m-d',strtotime($_POST['new_children_datetime']));?>
            <input type="hidden" name="children_datetime" value="<?php print($new_children_datetime);?>">
            <button class="btn btn-info" type="submit">戻る</button>
        </form>
    </div>
</body>
</html>