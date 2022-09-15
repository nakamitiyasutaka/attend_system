<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require("base_infomation.php");
        
            $personal = $DB->query("SELECT * FROM staff_attend");

    ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>勤怠検索ページ</title>
</head>
<body>
        <div class="bg-dark text-white container">
            <h2 class="p-4">勤怠検索ページ</h2>
                <form action="attend_update.php" method="GET">
                    <input class="m-4" type="date"name="staff_datetime" value="YYYY-MM-dd">
                    <button class="btn btn-primary" type="submit">検索</button>
                </form>
            
        </div>
        <div class="container">
            <h2 class="m-4">出勤内容</h2>
            <table class="table" style="table-layout:fixed;">
                <tr>
                    <th>名前</th>
                    <th>出勤内容</th>
                    <th>時間</th>
                </tr>
            </table>
        </div>
</body>
</html>