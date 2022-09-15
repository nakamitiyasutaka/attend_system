<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php
            require("base_infomation.php");

            // ページネージョン
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            } else {
                $page = 1;
            }

            if ($page > 1) {
                $start = ($page * 10) - 10;
            } else {
                $start = 0;
            }


            //検索条件のNULL処理
	    if(isset($_GET[''.$type.'_datetime'])){
                $staff_date = $_GET[''.$type.'_datetime'];
            }else{
                $staff_date = 0000-00-00;
            }
            $date_title;
            if($staff_date == ""){
                $date_title = "最新";
            }else {
                $date_title = date('Y年m月d日',strtotime($_GET[''.$type.'_datetime']));
            }
            if(isset($_GET[''.$type.'_name'])){
                $name = $_GET[''.$type.'_name'];
            }else{
                $name = "";
            }

            //日付、名前検索での処理
            if(!($name == "")){
                $data = $DB->prepare('SELECT '.$type.'_attend.id,'.$type.'_attend.'.$type.'_attend,'.$type.'_attend.'.$type.'_datetime,'.$type.'_info.'.$type.'_id,'.$type.'_info.'.$type.'_name FROM '.$type.'_attend
                INNER JOIN '.$type.'_info ON '.$type.'_attend.'.$type.'_id='.$type.'_info.'.$type.'_id
                WHERE '.$type.'_attend.'.$type.'_datetime LIKE \'%'.$staff_date.'%\'
                AND '.$type.'_name LIKE \'%'.$_GET[''.$type.'_name'].'%\' LIMIT '.$start.', 10');

            }else{
                $data = $DB->prepare('SELECT '.$type.'_attend.id,'.$type.'_attend.'.$type.'_attend,'.$type.'_attend.'.$type.'_datetime, '.$type.'_info.'.$type.'_id,'.$type.'_info.'.$type.'_name FROM '.$type.'_attend
                INNER JOIN '.$type.'_info ON '.$type.'_attend.'.$type.'_id='.$type.'_info.'.$type.'_id
                WHERE '.$type.'_attend.'.$type.'_datetime LIKE \'%'.$staff_date.'%\' LIMIT '.$start.', 10');

            }
            $data->execute();

            //カラム数のカウント取得
            if(!isset($_GET['count_data'])){
                if(!($name == "")){
                $count_data = $DB->query('SELECT count(*) FROM '.$type.'_attend
                INNER JOIN '.$type.'_info ON '.$type.'_attend.'.$type.'_id='.$type.'_info.'.$type.'_id
                WHERE '.$type.'_datetime LIKE"%'.$staff_date.'%"
                AND '.$type.'_name LIKE "%'.$_GET[''.$type.'_name'].'%" LIMIT '.$start.', 10');
                }else{
                    $count_data = $DB->query('SELECT count(*) FROM '.$type.'_attend
                    INNER JOIN '.$type.'_info ON '.$type.'_attend.'.$type.'_id='.$type.'_info.'.$type.'_id
                    WHERE '.$type.'_datetime LIKE"%'.$staff_date.'%" LIMIT '.$start.', 10');
                }
                $count = $count_data -> fetchColumn();
                $count_data = ceil(($count/10));
            }else{
                $count = $_GET['count'];
                $count_data = ceil(($count/10));
            }

        ?>
        <title>タイムカード編集画面</title>
    </head>
    <body>
            <div class="bg-dark text-white container">
                <h2 class="p-4">勤怠検索ページ</h2>

                    <form action="attend_update.php" method="GET">
                        <label for="<?php print($type);?>_datetime">日付</label>
                        <input class="m-4" type="date"name="<?php print($type);?>_datetime" value="YYYY-MM-dd">
                        <label for="<?php print($type);?>_name">なまえ</label>
                        <input type="text" name="<?php print($type);?>_name" size="20" maxlength="30">
                        <input type="hidden" name="type" value="<?php print($type);?>">
                        <button class="btn btn-primary" type="submit">検索</button>
                    </form>
            </div>
            <div class="container">
                <h2 class="p-4"><?php print($date_title);?>の出勤内容</h2>
                <p class="text-success">検索結果<?php print($count);?>件</p>
                <table class="table" style="table-layout:fixed;">
                    <tr>
                        <th>名前</th>
                        <th>出勤内容</th>
                        <th>時間</th>
                    </tr>
                    <?php while($person = $data->fetch()):?>
                            <form action="attend_cure.php" method="get">
                                <tr>
                                    <td><?php print($person[$type.'_name']);?></td>
                                    <td><?php print($person[$type.'_attend']);?></td>
                                    <td><?php print($person[$type.'_datetime']);?></td>
                                    <input type="hidden" name="id" value="<?php print($person['id']);?>">
                                    <input type="hidden" name="type" value="<?php print($type);?>">
                                    <td><button class="btn btn-success" type="submit" name="button_name" value="修正">修正</button></td>
                                    <td><button class="btn btn-success" type="submit" name="button_name" value="削除">削除</button></td>
                                </tr>
                            </form>
                    <?php endwhile;?>
                </table>
                <form action="attend_cure.php" method="get">
                    <p class="text-right">
                        <input type="hidden" name="type" value="<?php print($type);?>">
                        <button class="btn btn-primary" type="submit" name="new" value="新規追加">新規追加</button>
                    </p>
                </form>
                <!------以下ページネージョン-------->
                <?php
                    $range = 4;
                    if (
                    isset($_GET["page"]) &&
                    $_GET["page"] > 0 &&
                    $_GET["page"] <= $count_data
                    ) {
                    $page = (int)$_GET["page"];
                    } else {
                    $page = 1;
                    }
                ?>
                <p class="text-success"><?php echo $page; ?> ページ目</p>
                <p>
                <?php if ($page > 1) : ?>
                    <a class="text-success" href="?page=<?php echo ($page - 1); ?>&count=<?php echo $count;?>&count_data=<?php echo $count_data;?>&<?php print($type);?>_datetime=<?php print($staff_date);?>&<?php print($type);?>_name=<?php print($_GET[$type.'_name']);?>&type=<?php print($type);?>">前のページへ</a>
                <?php endif; ?>

                <?php for ($i = $range; $i > 0; $i--) : ?>
                    <?php if ($page - $i < 1) continue; ?>
                    <a class="text-success" href="?page=<?php echo ($page - $i); ?>&count=<?php echo $count;?>&count_data=<?php echo $count_data;?>&<?php print($type);?>_datetime=<?php print($staff_date);?>&<?php print($type);?>_name=<?php print($_GET[$type.'_name']);?>&type=<?php print($type);?>"><?php echo ($page - $i); ?></a>
                <?php endfor; ?>

                <span><?php echo $page; ?></span>

                <?php for ($i = 1; $i <= $range; $i++) : ?>
                    <?php if ($page + $i > $count_data) break; ?>
                    <a class="text-success" href="?page=<?php echo ($page + $i); ?>&count=<?php echo $count;?>&count_data=<?php echo $count_data;?>&<?php print($type);?>_datetime=<?php print($staff_date);?>&<?php print($type);?>_name=<?php print($_GET[$type.'_name']);?>&type=<?php print($type);?>"><?php echo ($page + $i); ?></a>
                <?php endfor; ?>

                <?php if ($page < $count_data) : ?>
                    <a class="text-info" href="?page=<?php echo ($page + 1); ?>&count=<?php echo $count;?>&count_data=<?php echo $count_data;?>&<?php print($type);?>_datetime=<?php print($staff_date);?>&<?php print($type);?>_name=<?php print($_GET[$type.'_name']);?>&type=<?php print($type);?>">次のページへ</a>
                <?php endif; ?>
                </p>
                <p class="text-right my-3"><a class="btn btn-primary text-white" href="login.php">戻る</a></p>
            </div>
    </body>
</html>
