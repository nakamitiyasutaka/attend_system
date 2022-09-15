
<?php
    require("base_infomation.php");


$fileName = "timecard.tab";
$file = fopen($fileName, "r");

while (!feof($file)) {
    $data = fgets($file);

    $data = mb_convert_encoding($data, "utf-8", "sjis");
    $data = str_replace("\t",",","$data");
    $data = str_replace("/","-","$data");
    $data = explode(",", $data);
    
    //DATEとTIMEの結合。
    $job_data=$data[3];
    $job_datetime = implode(",$job_data ",$data);
    $job_datetime = explode(",", $job_datetime);
    print_r($job_datetime);
    //---配列の結合の種類---
    print $data[3]." ".$data[4] . "\n";
    print implode(" ", array($data[3], $data[4])) . "\n";
    printf("%s %s\n", $data[3], $data[4]);
break;
$insert = $DB->exec("INSERT INTO work ( job_attend,job_number,job_timestamp,job_name)values('".$data[1]."','".$data[2]."','".$job_datetime."','".$data[5]."')");
}
?>
