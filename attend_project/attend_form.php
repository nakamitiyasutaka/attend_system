
<!DOCTYPE html>
<html lang="ja">
<?php
    require("base_infomation.php");

    $block_position = $DB->query("select i.".$type."_name, i.".$type."_id, a.".$type."_attend, a.".$type."_datetime
    from ".$type."_info as i left join (select ".$type."_id, max(".$type."_datetime) as ".$type."_datetime from ".$type."_attend group by ".$type."_id)
    as b on b.".$type."_id = i.".$type."_id left join ".$type."_attend as a on b.".$type."_datetime = a.".$type."_datetime and b.".$type."_id = a.".$type."_id order by b.".$type."_datetime desc
    ");

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print($title);?>タイムカード</title>
</head>
<body>
    <?php if(!isset($_GET['submit_button'])):?>
        <div class="container bg-success text-white p-3">
            <h1><?php print($title);?>タイムカード</h1>
            <p class="datetime_p text-center" id="RealtimeClockArea2"></p>
            <p class="text-right"><button class="btn-warning" >　　</button>は出勤中</p>
            <p class="text-right"><button class="btn-success" >　　</button>は退勤中</p>
            <p><?php if(isset($_GET['message'])){print($_GET['message']);}?></p>
        </div>
        <div class="container p-3">
            <div class="row justify-content-between flexitem">
                <?php
                    while($block = $block_position->fetch()):

                    if($block[$type.'_attend'] == $attend_column[0]){
                        date_default_timezone_set('Asia/Tokyo');
                        if(strtotime(date('y-m-d')) > strtotime($block[$type.'_datetime'])){
                            $datetime = new DateTime($block[$type.'_datetime']);
                            $datetime->modify('+1 days');
                            echo $datetime->format('Y-m-d 00:00:00');
                            $message = "未退勤がありましたので「自動退勤」しました。<br>".$block[$type.'_name']."　　".$block[$type.'_datetime'];
                            $DB->exec("INSERT INTO ".$type."_attend (".$type."_attend,".$type."_id,".$type."_datetime) VALUES('".$attend_column[2]."','".$block[$type.'_id']."','".$datetime->format('Y-m-d 03:00:00')."')");
                            echo'<meta http-equiv="refresh" content=" 0; url=./attend_form.php?type='.$type.'&message='.$message.'">';

                        }else{
                            $coller ="btn btn-warning";
                            $attend =$attend_column[1];
                            $datetime = $block[$type.'_datetime'];
                        }
                    }else{
                        if($block[$type.'_attend'] == $attend_column[1] || $block[$type.'_attend'] == $attend_column[2]){
                            $coller ="btn btn-success";
                            $attend =$attend_column[0];
                            $datetime = $block[$type.'_datetime'];
                        }
                        if($block[$type.'_attend'] == ""){
                            $coller ="btn btn-success";
                            $attend ="$attend_column[0]";
                            $datetime = "0000-00-00<br>00:00:00";
                        }
                    }
                ?>
                        <div class="col-2 m-1">
                            <form action="attend_form.php" method="get">
                                        <button type='submit' name="submit_button" class="<?php print($coller);?> " ><?php print($block[$type.'_name']."<br>".$datetime);?></button>
                                        <input type="hidden" name="<?php print($type);?>_name" value="<?php print($block[$type.'_name']);?>">
                                        <input type="hidden" name="<?php print($type);?>_id" value="<?php print($block[$type.'_id']);?>">
                                        <input type="hidden" name="<?php print($type);?>_datetime" value="<?php print($block[$type.'_datetime']);?>">
                                        <input type="hidden" name="<?php print($type);?>_attend" value="<?php print($attend);?>">
                                        <input type="hidden" name="type" value="<?php print($type);?>">
                            </form>
                        </div>
                <?php endwhile;?>
            </div>
            <p class="text-right my-5"><a class="btn btn-danger text-white" href="login.php">戻る</a></p>
        </div>
        <meta http-equiv="refresh" content=" 900; url=./attend_form.php?type=<?php print($type);?>">
    <?php endif;?>

    <!---各ボタン押下後の処理--->
    <?php if(isset($_GET['submit_button'])):?>
        <?php
        $type=$_GET['type'];
        $id = $_GET[$type.'_id'];
        $name = $_GET[$type.'_name'];
        $attend = $_GET[$type.'_attend'];

        echo "<br>".$name."さんは、".$attend."しました。";

        $DB->exec("INSERT INTO ".$type."_attend (".$type."_attend,".$type."_id) VALUES('".$attend."','".$id."')");
        ?>

    <meta http-equiv="refresh" content=" 1; url=./attend_form.php?type=<?php print($type);?>">



    <?php endif;?>
</body>
</html>

