
<?php
    require("base_infomation.php");


$fileName = "report.tab";
$file = fopen($fileName, "r");

while (!feof($file)) {
    $data = fgets($file);

    //$data = mb_convert_encoding($data, "utf-8", "sjis");
    $data = str_replace("\t",",","$data");
    $data = str_replace("年","-","$data");
    $data = str_replace("月","-","$data");
    $data = str_replace("日","","$data");
    //$data = str_replace("","\n","$data");
    $data = explode(",", $data);
    print_r($data);
break;

$insert="report_id,report_date,report_all_0,report_contact_0,report_child_0,report_reflection_0,report_all_1,report_contact_1,report_child_1,report_reflection_1,report_all_2,report_contact_2,report_child_2,report_reflection_2,report_aim_0,report_aim_1,report_aim_2,report_yobi";
$insert = $DB->exec("INSERT INTO report ($insert)values('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."','".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".$data[20]."')");
}
?>
