
<?php
    require("base_infomation.php");

$fileName = "childrenDB.tab";
$file = fopen($fileName, "r");

while (!feof($file)) {
    $data = fgets($file);

    //$data = mb_convert_encoding($data, "utf-8", "sjis");
    $data = str_replace("\t",",","$data");
    $data = str_replace("/","-","$data");
    $data = str_replace("","","$data");
    $data = str_replace("","","$data");
    $data = str_replace("","<br>","$data");
    $data = explode(",", $data);
    print_r($data);

$insert="children_id,children_situation,children_name_kana,children_name,children_birthday,children_address,children_family_kana,children_family,family_birthday,family_relationship,children_reason,family_TEL";
$insert = $DB->exec("INSERT INTO cildrenDB ($insert)values('".$data[0]."','".$data[3]."','".$data[2]."','".$data[4]."','".$data[16]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[11]."','".$data[12]."','".$data[15]."','".$data[13]."')");

}
?>
