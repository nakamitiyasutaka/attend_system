
<!DOCTYPE html>
<html lang="ja">
<?php
    require("base_infomation.php");

    $block_position = $DB->query("SELECT id,children_id,MAX(children_datetime) FROM children_attend GROUP BY children_id ORDER BY MAX(children_datetime) DESC");
    $bloch_num = 1;
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠</title>
</head>

<body>
    <?php if(!isset($_GET['submit_button'])):?>
        <div class="container  bg-success text-white p-3">
            <h1 class="my-4">従業員タイムカード</h1>
            <p class="datetime_p text-center" id="RealtimeClockArea"></p>
        </div>
        <div class="container p-3">
            <div class="row justify-content-between flexitem">
                <?php
                    while($block = $block_position->fetch()):

                    $personal = $DB->query("SELECT * FROM children_info WHERE children_id = '".$block['children_id']."' ");
                    while($children = $personal->fetch()):
                    $attend_array = array("登園", "降園");
                    $children_id =$children['children_id'];
                    $work = $DB->query("SELECT * FROM children_attend WHERE children_id='".$children_id."' ORDER BY children_datetime DESC" );
                    $c = $work->rowCount();
                    $attend = $attend_array[$c % 2];
                    if($attend == "登園"){
                        $coller ="btn btn-success";
                    }else{
                        $coller ="btn btn-warning";
                    }
                    $work = $work->fetch();

                ?>
                        <div class="col-2 m-1">
                            <form action="children_attendForm.php" method="get">
                                        <button type='submit' name="submit_button" class="<?php print($coller);?> " ><?php print($children['children_name']."<br>".$work['children_datetime']);?></button>
                                        <input type="hidden" name="id" value="<?php print($children['children_id']);?>">
                                        <input type="hidden" name="name" value="<?php print($children['children_name']);?>">
                                        <input type="hidden" name="attend" value="<?php print($attend);?>">
                            </form>
                        </div>
                <?php  $bloch_num++; endwhile; endwhile;?>
            </div>
            <a href="report_search.php">日誌一覧ページへ</a><br>
            <a href="children_info.php">園児一覧へ</a><br>
            <a href="attendForm.php">従業員タイムカードへ</a>
        </div>
    <?php endif;?>

    <!---各ボタン押下後の処理--->
    <?php if(isset($_GET['submit_button'])):?>
        <?php
        require("require_PDO.php");

        $children_id = $_GET['id'];
        $children_name = $_GET['name'];
        $children_attend = $_GET['attend'];

        echo $children_name,"さんは、",$children_attend,"しました。<br>";
        $DB->exec("INSERT INTO children_attend (children_id,children_attend) VALUES('".$children_id."','".$children_attend."')");
        ?>

    <meta http-equiv="refresh" content=" 1; url=./children_attendForm.php">



    <?php endif;?>

</body>
</html>

