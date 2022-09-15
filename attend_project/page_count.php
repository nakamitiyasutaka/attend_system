<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>サンプル</title>

<?php
    require("base_infomation.php");

  if (isset($_GET['page'])) {
	$page = (int)$_GET['page'];
} else {
	$page = 1;
}

// スタートのポジションを計算する
if ($page > 1) {
	// 例：２ページ目の場合は、『(2 × 10) - 10 = 10』
	$start = ($page * 10) - 10;
} else {
	$start = 0;
}


  $posts = $DB->prepare("SELECT * FROM children_attend LIMIT {$start}, 10");

    $posts->execute();
        $posts = $posts->fetchAll(PDO::FETCH_ASSOC);

    foreach ($posts as $post) {
        print($post['children_id']. '：');
        print($post['children_attend'].'<br>');
    }


$totalPage = 20;
$range = 3;
if (
  isset($_GET["page"]) &&
  $_GET["page"] > 0 &&
  $_GET["page"] <= $totalPage
) {
  $page = (int)$_GET["page"];
} else {
  $page = 1;
}

?>
</head>
<body>
  <p>現在 <?php echo $page; ?> ページ目です。</p>

  <p>
    <?php if ($page > 1) : ?>
      <a href="?page=<?php echo ($page - 1); ?>">前のページへ</a>
    <?php endif; ?>

    <?php for ($i = $range; $i > 0; $i--) : ?>
      <?php if ($page - $i < 1) continue; ?>
      <a href="?page=<?php echo ($page - $i); ?>"><?php echo ($page - $i); ?></a>
    <?php endfor; ?>

    <span><?php echo $page; ?></span>

    <?php for ($i = 1; $i <= $range; $i++) : ?>
      <?php if ($page + $i > $totalPage) break; ?>
      <a href="?page=<?php echo ($page + $i); ?>"><?php echo ($page + $i); ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPage) : ?>
      <a href="?page=<?php echo ($page + 1); ?>">次のページへ</a>
    <?php endif; ?>
  </p>

</body>
</html>