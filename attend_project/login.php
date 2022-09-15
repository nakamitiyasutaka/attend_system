<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
        require("require_PDO.php");
    ?>
<link rel="stylesheet" href="style_01.css">
<script type="text/javascript" src="style.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"-->

</head>
<body>
    <div class="container bg-secondary text-white py-5">
    <h2>ログイン</h2>
    </div>
    <div class="container my-5">
    <div class="row justify-content-between flexitem">
        <div class="col-12 p-3">
            <a class="btn btn-primary text-white btn-lg w-25" href="attend_form.php?type=children">園児タイムカード</a>
            <a class="btn btn-primary text-white btn-lg w-25" href="attend_update.php?type=children&children_datetime=<?php echo date('Y-m-d');?>">園児タイムカード編集</a>
            <a class="btn btn-primary text-white btn-lg w-25" href="staff_info.php?type=children">園児基本情報</a>
        </div>
        <div class="col-12 p-3">
            <a class="btn btn-primary text-white btn-lg w-25" href="attend_form.php?type=staff">従業員タイムカード</a>
            <a class="btn btn-primary text-white btn-lg w-25" href="attend_update.php?type=staff&staff_datetime=<?php echo date('Y-m-d');?>">従業員タイムカード編集</a>
            <a class="btn btn-primary text-white btn-lg w-25 " href="staff_info.php?type=staff">従業員従業員基本情報</a>
        </div>
    </div>
    </div>
</body>
</html>