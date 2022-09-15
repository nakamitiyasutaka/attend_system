<?php
    require("base_infomation.php");

    $children_id = $_POST['id'];
    $children_name = $_POST['name'];
    $children_attend = $_POST['attend'];
    echo $children_name,"さんは、",$children_attend,"しました。<br>";
?>

