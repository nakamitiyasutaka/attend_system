<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <?php
    require("base_infomation.php");

        //$report_date = $_GET['report_date'];
        $data = $DB->prepare("SELECT * FROM report WHERE report_date=?");
        $cildren = $data->execute(array($_GET['report_date']));
        $cildren = $data->fetch();
    ?>
    <div class="container">
    <div class ="my-3">
        <form action="report_search.php" method="GET">
            <input type="date"name="report_date" value="YYYY-MM-dd">
            <button type="submit">検索</button>
        </form>
    </div>
    <div class="row mt-5 mb-3">
        <h3 class ="col-4">日付（曜日）</h3>
        <p class = "col-8"><?php print($cildren['report_date'].$cildren['report_yobi']);?></p>
    </div>
    <div class="row my-3">
        <h3 class ="col-4">全体の様子</h3>
        <p class="col-8"><?php print($cildren['report_all_0']);?></p>
    </div>
    <div class="row my-3">
        <h3 class = "col-4">ねらい</h3>
        <p class = "col-8"><?php print($cildren['report_aim_0']);?></p>
    </div>
    <div class ="row my-3">
        <h3 class="col-4">個別連絡事項</h3>
        <p class ="col-8"><?php print($cildren['report_contact_0']);?></p>
    </div>
        <h3 class="my-3">こどもの様子（個別）</h3>
        <p class ="my-3"><?php print($cildren['report_child_0']);?></p>
        <h3 class ="my-3">反省・評価（個別）</h3>
        <p class ="my-3"><?php print($cildren['report_reflection_0']);?></p>

        <a href="children_info.php">園児一覧へ</a><br>
        <a href="children_attendForm.php">園児登園確認ページへ</a><br>
        <a href="attendForm.php">従業員一覧へ</a>
    </div>
        </body>
</html>