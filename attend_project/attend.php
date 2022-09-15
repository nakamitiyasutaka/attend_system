<?php
    require("base_infomation.php");

    $jstaff_number = $_POST['id'];
    $staff_name = $_POST['name'];
    $staff_attend = $_POST['attend'];
    echo $staff_name,"さんは、",$staff_attend,"しました。";

$DB->exec("INSERT INTO staff_attend (staff_attend,staff_number) VALUES('".$staff_attend."','".$staff_number."')");

?>

<meta http-equiv="refresh" content=" 1; url=./attendForm.php">