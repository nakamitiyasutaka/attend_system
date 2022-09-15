

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require("base_infomation.php");

        $data = $DB->prepare("SELECT * FROM children_info WHERE children_id=?");
        $children = $data->execute(array($_REQUEST['children_id']));
        $children = $data->fetch();
    ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>詳細情報</title>
</head>
<body>
    <table class="table table-striped">
            <tr class="table-warning">
                <th>ID</th>
                <th>状況</th>
                <th>氏名</th>
                <th>カタカナ</th>
                <th>住所</th>
                <th>家族（氏名）</th>
                <th>（カタカナ）</th>
                <th>続柄</th>
                <th>保育理由</th>
                <th>電話番号</th>
            </tr>
            <tr>
                <td><?php print($children['children_id']);?></td>
                <td><?php print($children['children_contract_type']);?></td>
                <td><?php print($children['children_name']);?></td>
                <td><?php print($children['children_name_kana']);?></td>
                <td><?php print($children['children_address']);?></td>
                <td><?php print($children['children_family']);?></td>
                <td><?php print($children['children_family_kana']);?></td>
                <td><?php print($children['family_relationship']);?></td>
                <td><?php print($children['children_reason']);?></td>
                <td><?php print($children['family_TEL']);?></td>
            </tr>
    </table>
    <a href="children_info.php">戻る</a>
</body>
</html>

