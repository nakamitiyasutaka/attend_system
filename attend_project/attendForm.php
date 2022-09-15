
<!DOCTYPE html>
<html lang="ja">
<?php
    require("base_infomation.php");
    if(isset($_GET['type'])){
        $type=$_GET['type'];
    }

    $block_position = $DB->query("SELECT id,staff_number,MAX(staff_datetime) FROM staff_attend GROUP BY staff_number ORDER BY MAX(staff_datetime) DESC");
    $bloch_num = 1;
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タイムカード</title>
</head>

<body>
    <?php if(!isset($_GET['submit_button'])):?>
        <div class="container bg-success text-white p-3">
            <h1>従業員タイムカード</h1>
            <p class="datetime_p text-center" id="RealtimeClockArea"></p>
        </div>
        <div class="container p-3">
            <div class="row justify-content-between flexitem">
                <?php
                    while($block = $block_position->fetch()):

                    $personal = $DB->query("SELECT * FROM staff_info WHERE staff_number = '".$block['staff_number']."' ");
                    while($staff = $personal->fetch()):
                    $attend_array = array("出勤", "退勤");
                    $work = $DB->query("SELECT * FROM staff_attend WHERE staff_number='".$staff['staff_number']."' ORDER BY staff_datetime DESC" );
                    $c = $work->rowCount();
                    $attend = $attend_array[$c % 2];
                    if($attend == "出勤"){
                        $coller ="btn btn-success";
                    }else{
                        $coller ="btn btn-warning";
                    }
                    $work = $work->fetch();

                ?>
                        <div class="col-2 m-1">
                            <form action="attendForm.php" method="get">
                                        <button type='submit' name="submit_button" class="<?php print($coller);?> " ><?php print($staff['staff_name']."<br>".$work['staff_datetime']);?></button>
                                        <input type="hidden" name="staff_id" value="<?php print($staff['staff_number']);?>">
                                        <input type="hidden" name="staff_name" value="<?php print($staff['staff_name']);?>">
                                        <input type="hidden" name="staff_attend" value="<?php print($attend);?>">
                            </form>
                        </div>
                <?php  $bloch_num++; endwhile; endwhile;?>
            </div>
            <a href="report_search.php">日誌一覧ページへ</a><br>
            <a href="children_info.php">園児一覧へ</a><br>
            <a href="children_attendForm.php">園児タイムカードへ</a>
        </div>
    <?php endif;?>

    <!---各ボタン押下後の処理--->
    <?php if(isset($_GET['submit_button'])):?>
        <?php

        $staff_number = $_GET['staff_id'];
        $staff_name = $_GET['staff_name'];
        $staff_attend = $_GET['staff_attend'];

        echo $staff_number.$staff_name,"さんは、",$staff_attend,"しました。<br>";
        $DB->exec("INSERT INTO staff_attend (staff_attend,staff_number) VALUES('".$staff_attend."','".$staff_number."')");
        ?>

    <meta http-equiv="refresh" content=" 1; url=./attendForm.php">



    <?php endif;?>

    

</body>
</html>

