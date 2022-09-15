<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require("base_infomation.php");
    require('item_ditaile.php');

    $data = $DB->query("$info_sql");
    ?>
    <title>従業員一覧</title>
</head>
<body>
    <div class="container">
        <table class="table table-striped">
            <tr class="table-warning">
            <?php for($i = 0; $i < $column_count ; $i++):?>
                <th><?php print($column_name[$i]);?></th>
            <?php endfor;?>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <?php while($person = $data->fetch()):
                $today = date("Y-m-d");
                if($type=="children"){
                    //$until = floor(((strtotime($today) - strtotime($person[''.$type.'_birthday'])) / 86400/365)).'さい';
                    if($person[''.$type.'_contract_type'] == "短縮保育")
                    {$text_coller = "text-danger";}else{$text_coller ="";}
                }
                else{
                    $until ="";
                }

            ?>
            <tr>
            <?php for($i = 0; $i < $column_count ; $i++):?>
                <td class="<?php print($text_coller) ?>"><?php print($person[$column[$i]]);?></td>
            <?php endfor;?>

                <td><?php if($type=="children"):?>
                <a class="btn btn-outline-warning" href="<?php print($type);?>_info_cure.php?children_id=<?php print($person[$column[0]]);?>&detail=詳細情報&type=<?php print($type);?>">詳細</a>
                <?php endif;?></td>
                <td><?php if($type=="children"):?>
                    <a class="btn btn-outline-info" href="children_info_cure.php?<?php print($type);?>_id=<?php print($person[$column[0]]);?>&edit=情報修正&type=<?php print($type);?>">修正</a>
                    <a class="btn btn-outline-info" href="children_info_cure.php?<?php print($type);?>_id=<?php print($person[$column[0]]);?>&delete=情報削除&type=<?php print($type);?>">削除</a>
                <?php endif;?></td>
                <td><?php if($type=="staff" || $type=="noon_staff" || $type=="cost"):?>
                    <a class="btn btn-outline-info" href="staff_info_cure.php?<?php print($type);?>_id=<?php print($person[$column[0]]);?>&edit=情報修正&type=<?php print($type);?>">修正</a>
                    <a class="btn btn-outline-info" href="staff_info_cure.php?<?php print($type);?>_id=<?php print($person[$column[0]]);?>&delete=情報削除&type=<?php print($type);?>">削除</a>
                <?php endif;?></td>
            </tr>
            <?php endwhile;?>
        </table>
        <form action="<?php print($new_entry_title);?>_info_cure.php">
                <p class="text-right"><button type="submit" class="btn btn-info" name="new" value="新規登録">新規登録</button></p>
                <input type="hidden" name="type" value="<?php print($type);?>">
        </form>
        <p class="text-right"><a class="btn btn-info text-white" href="login.php">戻る</a></p>
    </div>
</body>
</html>

