<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require("base_infomation.php");
    ?>
    <title>Document</title>
</head>
<body>
    <?php if(isset($_GET['edit'])):?>
        <div class="container bg-secondary text-white py-5">
            <h1 class="my-5 ">修正画面</h1>
        </div>
        <div class="container">
            <?php
             if(isset($_GET['cure'])){
                //
                if($type=="staff" || $type=="noon_staff"){
                $DB->exec("UPDATE ".$type."_info SET
                ".$type."_role = '".$_GET[$column[1]]."',
                ".$type."_name = '".$_GET[$column[2]]."',
                ".$type."_name_kana = '".$_GET[$column[3]]."',
                ".$type."_date_in = '".$_GET[$column[4]]."'
                WHERE ".$type."_id = '".$_GET[$column[0]]."'");
                }
                if($type=="cost"){
                    $DB->exec("UPDATE ".$type."_info SET
                    ".$column[1]." = '".$_GET[$column[1]]."',
                    ".$column[2]." = '".$_GET[$column[2]]."'
                    WHERE ".$column[0]." = '".$_GET[$column[0]]."'");
                }
            }
            ?>
            <form action="staff_info_cure.php" method = GET>
                <div class="my-5 ">
                    <?php
                        $data = $DB->query("SELECT * FROM ".$type."_info WHERE ".$column[0]." = '".$_GET[$column[0]]."'");
                        $item = $data->fetch();
                            for($i = 0; $i < $column_count; $i++):
                            if($i == 4):?>
                            <label for="<?php print($item[$column[$i]]);?>"><?php print($column_name[$i]);?></label>
                            <input type="date" name="<?php print($column[$i]);?>" value="<?php print($item[$column[$i]]);?>">
                        <?php elseif($i == 0):?>
                            <input type="hidden" name="<?php print($column[$i]);?>" value="<?php print($item[$column[$i]]);?>">
                        <?php else:?>
                            <label for="<?php print($column[$i]);?>"><?php print($column_name[$i]);?></label>
                            <input type="text" name="<?php print($column[$i]);?>" value="<?php print($item[$column[$i]]);?>">
                        <?php endif;?>
                    <?php endfor;?>
                </div>
                <input type="hidden" name="edit" vulue="edit">
                <input type="hidden" name="type" value="<?php print($type);?>">
                <input type="hidden" name="cure" value="修正しました">
                <p class="text-right"><button class="btn btn-success text-white" onClick="return Check1()" type="submit">修正</button></p>
            </form>
            <p class="text-right"><a class="btn btn-primary text-white" href="staff_info.php?type=<?php print($type);?>">戻る</a></p>
        </div>
    <?php endif;?>
    <?php if(isset($_GET['delete'])):?>
        <div class="container bg-secondary text-white py-5">
            <h1>削除画面</h1>
        </div>
        <div class="container">
            <?php
             if(isset($_GET['cure'])):
                print($_GET['cure']);
                $DB->exec("DELETE FROM ".$type."_info WHERE ".$type."_id = '".$_GET[$column[0]]."'");
            ?>
            <?php else:?>
                <form action="staff_info_cure.php" method = GET>
                <p class="my-5"><?php
                        $data = $DB->query("SELECT * FROM ".$type."_info WHERE ".$type."_id = '".$_GET[$type.'_id']."'");
                        $item = $data->fetch();
                        for($i = 0; $i < $column_count; $i++):?>
                            <?php print($column_name[$i]);?>　：　<?php print($item[$column[$i].'']);?>　　
                            <input type="hidden" name="<?php print($column[$i]);?>" value="<?php print($item[$column[$i]]);?>">
                    <?php endfor;?></p>
                    <input type="hidden" name="delete" vulue="delete">
                    <input type="hidden" name="type" value="<?php print($type);?>">
                    <input type="hidden" name="cure" value="削除しました">
                    <p class="text-right"><button class="btn btn-success text-white" onClick="return Check2()" type="submit">削除</button></p>
                </form>
            <?php endif;?>
            <p class="text-right"><a class="btn btn-primary text-white" href="staff_info.php?type=<?php print($type);?>">戻る</a></p>
        </div>
    <?php endif;?>
    <?php if(isset($_GET['new'])):?>
        <div class="container bg-secondary text-white py-5">
            <h1>新規作成画面</h1>
        </div>
        <div class="container">
            <?php 
                if(isset($_GET['cure'])){
                print($_GET['cure']);
                    if($type=="staff"){
                        $DB->exec("INSERT INTO ".$type."_info (".$type."_name,".$type."_name_kana,".$type."_date_in,".$type."_role)
                        VALUES('".$_GET[$type.'_name']."','".$_GET[$type.'_name_kana']."','".$_GET[$type.'_date_in']."','".$_GET[$type.'_role']."')");
                    }
                    if($type=="cost"){
                        $DB->exec("INSERT INTO ".$type."_info (".$column[1].",".$column[2].")
                        VALUES('".$_GET[$column[1]]."','".$_GET[$column[2]]."')");
                    }

                }
            ?>
            <p class="my-5"><form action="staff_info_cure.php" method = GET>
                <?php
                    for($i = 0; $i < $column_count; $i++):
                    if($i == 4):?>
                    <label for="<?php print($item[''.$column[$i].'']);?>"><?php print($column_name[$i]);?></label>
                    <input type="date" name="<?php print($column[$i]);?>" value="">
                    <?php elseif($i==0):?>
                    <input type="hidden">
                    <?php else:?>
                        <label for="<?php print($column[$i]);?>"><?php print($column_name[$i]);?></label>
                        <input type="text" name="<?php print($column[$i]);?>" value="">
                    <?php endif;?>
                <?php endfor;?>
                <input type="hidden" name="new" vulue="new">
                <input type="hidden" name="type" value="<?php print($type);?>">
                <input type="hidden" name="cure" value="新しく作成しました">
                <p class="text-right my-3"><button class="btn btn-success text-white" onClick="return Check3()" type="submit">登録</button></p>
            </form></p>
            <p class="text-right"><a class="btn btn-primary text-white" href="<?php print($new_entry_title)?>_info.php?type=<?php print($type);?>">戻る</a></p>
        </div>
    <?php endif;?>
</body>
</html>