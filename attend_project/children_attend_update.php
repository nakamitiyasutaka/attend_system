<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
        if(isset($_GET['children_datetime'])){
            $children_date = $_GET['children_datetime'];
        }else{
            $children_date = 0000-00-00;
        }
        $date_title;
        if($children_date == ""){
            $date_title = "最新";
        }else {
            $date_title = date('Y年m月d日',strtotime($_GET['children_datetime']));
        }

        if(isset($_GET['children_name'])){
            $name = $_GET['children_name'];
        }else{
            $name = "";
        }

        //日付、名前検索での処理
        if(!($name == "")){
                $data = $DB->prepare('SELECT * FROM children_attend
                INNER JOIN children_info ON children_attend.children_id=children_info.children_id
                WHERE children_datetime LIKE"%'.$children_date.'%"
            AND children_name LIKE "%'.$_GET['children_name'].'%" LIMIT '.$start.', 10');
        }else{
            $data = $DB->prepare('SELECT * FROM children_attend
            INNER JOIN children_info ON children_attend.children_id=children_info.children_id
            WHERE children_datetime LIKE "%'.$children_date.'%" LIMIT '.$start.', 10');

        }
        $data->execute();

        //カラム数のカウント取得
        if(!isset($_GET['count_data'])){
            if(!($name == "")){
                $count_data = $DB->query('SELECT count(*) FROM children_attend
                INNER JOIN children_info ON children_attend.children_id=children_info.children_id
                WHERE children_datetime LIKE "%'.$children_date.'%"
                AND children_name LIKE "%'.$_GET['children_name'].'%" LIMIT '.$start.', 10');
            }else{
                $count_data = $DB->query('SELECT count(*) FROM children_attend
                INNER JOIN children_info ON children_attend.children_id=children_info.children_id
                WHERE children_datetime LIKE "%'.$children_date.'%" LIMIT '.$start.', 10');
            }
            $count = $count_data -> fetchColumn();
            $count_data = ceil(($count/10));
        }else{
            $count = $_GET['count'];
            $count_data = ceil(($count/10));
        }

    ?>
    <title>Document</title>
</head>
<body>
        <div class="bg-dark text-white container">
            <h2 class="p-4">園児出欠検索ページ</h2>
            <?php
                $children_name = $DB->query("SELECT children_name FROM children_info");
                $children_name = $children_name->fetch()
            ?>
                <form action="children_attend_update.php" method="GET">
                    <label for="children_datetime">日付</label>
                    <input class="m-4" type="date"name="children_datetime" value="YYYY-MM-dd">
                    <label for="children_name">なまえ</label>
                    <input type="text" name="children_name" size="20" maxlength="30">
                    <button class="btn btn-danger" type="submit">検索</button>
                </form>
        </div>
        <div class="container">
            <h2 class="p-4"><?php print($date_title);?>の園児出欠内容</h2>
            <p class="text-info">検索結果<?php print($count);?>件</p>

            <table class="table" style="table-layout:fixed;">
                <tr>
                    <th>名前</th>
                    <th>出欠種類</th>
                    <th>時間</th>
                </tr>
                <?php while($person = $data->fetch()):
                    $children_data = $DB->query("SELECT * FROM children_info WHERE children_id = '".$person['children_id']."'");
                    $children = $children_data->fetch();
                    ?>
                        <form action="children_attend_cure.php" method="get">
                            <tr>
                                <td><?php print($children['children_name']);?></td>
                                <td><?php print($person['children_attend']);?></td>
                                <td><?php print($person['children_datetime']);?></td>
                                <input type="hidden" name="id" value="<?php print($person['id']);?>">
                                <td><button class="btn btn-info" type="submit" name="button_name" value="修正">修正</button></td>
                                <td><button class="btn btn-info" type="submit" name="button_name" value="削除">削除</button></td>
                            </tr>
                        </form>
                <?php endwhile;?>
            </table>
            <form action="children_attend_cure.php" method="get">
            <p class="text-right">
                <button class="btn btn-danger" type="submit" name="new" value="新規追加">新規追加</button>
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
                <p class="text-info"><?php echo $page; ?> ページ目</p>
                <p>
                <?php if ($page > 1) : ?>
                    <a class="text-info" href="?page=<?php echo ($page - 1); ?>&count=<?php echo $count;?>&count_data=<?php echo $count_data;?>&children_datetime=<?php print($_GET['children_datetime']);?>&children_name=<?php print($_GET['children_name']);?>">前のページへ</a>
                <?php endif; ?>

                <?php for ($i = $range; $i > 0; $i--) : ?>
                    <?php if ($page - $i < 1) continue; ?>
                    <a class="text-info" href="?page=<?php echo ($page - $i); ?>&count=<?php echo $count;?>&count_data=<?php echo $count_data;?>&children_datetime=<?php print($_GET['children_datetime']);?>&children_name=<?php print($_GET['children_name']);?>"><?php echo ($page - $i); ?></a>
                <?php endfor; ?>

                <span><?php echo $page; ?></span>

                <?php for ($i = 1; $i <= $range; $i++) : ?>
                    <?php if ($page + $i > $count_data) break; ?>
                    <a class="text-info" href="?page=<?php echo ($page + $i); ?>&count=<?php echo $count;?>&count_data=<?php echo $count_data;?>&children_datetime=<?php print($_GET['children_datetime']);?>&children_name=<?php print($_GET['children_name']);?>"><?php echo ($page + $i); ?></a>
                <?php endfor; ?>

                <?php if ($page < $count_data) : ?>
                    <a class="text-info" href="?page=<?php echo ($page + 1); ?>&count=<?php echo $count;?>&count_data=<?php echo $count_data;?>&children_datetime=<?php print($_GET['children_datetime']);?>&children_name=<?php print($_GET['children_name']);?>">次のページへ</a>
                <?php endif; ?>
                </p>

        </div>
</body>
</html>