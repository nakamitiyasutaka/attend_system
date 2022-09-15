<!DOCTYPE html>
<html lang="ja">
<head>
<?php
    require("base_infomation.php");

    $data = $DB->query("SELECT * FROM cildrenDB ");
    ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<p>月別登園合計時間</p>
<table class="table table-striped">
            <tr class="table-warning">
                <th>ID</th>
                <th>状況</th>
                <th>氏名</th>
                <th>カタカナ</th>
                <th>生年月日</th>
                <th></th>
            </tr>
            <?php while($cildren = $data->fetch()): ?>
            <tr>
                <td><?php print($cildren['children_id']);?></td>
                <td><?php print($cildren['children_situation']);?></td>
                <td><?php print($cildren['children_name']);?></td>
                <td><?php print($cildren['children_name_kana']);?></td>
                <td><?php print($cildren['children_birthday']);?></td>
                <td><input type="date"></td>
                <td>保育（標準時間）<input type="radio" name ="Contract" value="保育（標準時間）">保育（短縮時間）<input type="radio"　name="保育（短縮時間）"></td>
                <td><a href="detailed_info.php?children_id=<?php print($cildren['children_id']);?>">詳細情報</a></td>
            </tr>
            <?php endwhile;?>
    </table>
    <a href="report_search.php">日誌一覧ページへ</a><br>
    <a href="children_attendForm.php">園児登園確認ページへ</a><br>
    <a href="attendForm.php">従業員一覧へ</a>
</body>
</html>