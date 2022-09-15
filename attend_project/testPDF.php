<?php
include "./tcpdf/tcpdf.php"; // include_path配下に設置したtcpdf.phpを読み込む
$tcpdf = new TCPDF();
require("base_infomation.php");
session_start();
if(isset($_POST['month']) && isset($_POST['children_name'])){
    $month = $_POST['month'];
    $children_name = $_POST['children_name'];
}else{
    $month = "";
    $children_name = "";
}
    $month_item = date('Y年m月', strtotime($month));
    $month = date('t', strtotime($month));
    $today = date("Y年m月d日");
    $ded_line = date('Y年m月10日', strtotime(date('Y-m-d').'+1 month'));
    $number = date("Ymd");

    if($children_data = $DB->query("SELECT children_id,children_family,children_contract_type from children_info where children_name like '%".$children_name."%'")){
            $children_id = $children_data ->fetch();
            $children_family = json_decode( $children_id['children_family'] , true ) ; //家族情報をjson形式から変換
    }
    else{
        $children_family = "検索できませんでした";
    }
$seikyu_cost_total = $_POST['seikyu_cost_total'] + $_POST['not_payment'];
$attend_cost_array = $_SESSION['attend_cost_array_total'];
$attend_cost_array_total = json_decode($_SESSION['attend_cost_array_total'], true ) ;

$tcpdf->AddPage(); // 新しいpdfページを追加
 
$tcpdf->SetFont("kozgopromedium", "", 10); // デフォルトで用意されている日本語フォント
$tcpdf->SetTextColor(0,0,0);
$source = $children_family[0]['name'];
$source .= '　　　　様';
$tcpdf->SetXY(15, 10);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->Line(7,17,37,17, array('width' => 0.3));
$source = $children_name;
$tcpdf->SetXY(6, 18);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->Line(7,25,50,25, array('width' => 0.3));
$tcpdf->SetFont("kozgopromedium", "", 8);
$source ='NO.';
$tcpdf->SetXY(120, 2);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source = $_POST['print_number'];
$tcpdf->SetXY(150, 2);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source = $today;
$tcpdf->SetXY(180, 2);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->SetFont("kozgopromedium", "", 15); 
$source ='＊＊＊＊保育園';
$tcpdf->SetXY(161, 10);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->SetFont("kozgopromedium", "", 8); 
$source ='＊＊＊＊＊＊＊';
$tcpdf->SetXY(166, 15);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='TEL000-000-0000 FAX';
$tcpdf->SetXY(161, 19);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='代表取締役　　＊＊　＊＊＊＊';
$tcpdf->SetXY(164, 23);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->SetFont("kozgopromedium", "", 24); 
$source = $month_item;
$source .= '分保育料請求書';
$tcpdf->SetXY(95, 29);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');

$tcpdf->SetFont("kozgopromedium", "", 8); 
$source ='下記の通り保育代金等をご請求いたします。';
$tcpdf->SetXY(39, 38);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='代金のお支払いは、';
$source .= $ded_line;
$source .='までに下記の入金方法にてお願いいたします。';

$tcpdf->SetXY(59, 42);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');

$tcpdf->SetFont("kozgopromedium", "", 24); 
$source ='請求金額　';
$source .= $seikyu_cost_total;
$source .= '円';
$tcpdf->SetXY(95, 49);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->Line(55,60,155,60, array('width' => 0.3));
$tcpdf->Line(7,61,203,61, array('width' => 0.3));

$tcpdf->SetFont("kozgopromedium", "", 10);
$source ='保育実施日';
$tcpdf->SetXY(7, 60);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='実施';
$tcpdf->SetXY(37, 60);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='延長保育費';
$tcpdf->SetXY(70, 60);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='保育実施日';
$tcpdf->SetXY(102, 60);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='実施';
$tcpdf->SetXY(132, 60);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='延長保育費';
$tcpdf->SetXY(167, 60);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->Line(7,66.5,203,66.5, array('width' => 0.3));
$tcpdf->Line(100,61,100,146, array('width' => 0.3));
$tcpdf->Line(100,146,203,146, array('width' => 0.3));

$cost_width_A = 5;
$cost_width_B = 100;
$cost_hight_A = 60;
$cost_hight_B = 60;
$cost_line_hight_A = 66;
$cost_line_hight_B = 66;

for($i=0; $i<=30; $i++){     //延長保育料レイアウト
    if($i < 16){
        $cost_hight_A = $cost_hight_A + 5;
        $tcpdf->SetXY($cost_width_A, $cost_hight_A);
        $cost_line_hight_A = $cost_line_hight_A + 5;
        $tcpdf->Line(7,$cost_line_hight_A,100,$cost_line_hight_A, array('width' => 0.1));
        $source = $attend_cost_array_total[$i]['date_name'];
        $source .= '日';
        $tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
        $tcpdf->SetFont("kozgopromedium", "", 9); // 文字の調節
        $source = $attend_cost_array_total[$i]['children_datetime_total'];
        $tcpdf->SetXY(37, $cost_hight_A);
        $tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
        $tcpdf->SetFont("kozgopromedium", "", 10); // 文字の調節
        $source = $attend_cost_array_total[$i]['children_date'];
        $tcpdf->SetXY(70, $cost_hight_A);
        $tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');


    }
    if($i >= 16){
        $cost_hight_B = $cost_hight_B + 5;
        $tcpdf->SetXY($cost_width_B, $cost_hight_B);
        $cost_line_hight_B = $cost_line_hight_B + 5;
        $tcpdf->Line(100,$cost_line_hight_B,203,$cost_line_hight_B, array('width' => 0.1));
        $source = $attend_cost_array_total[$i]['date_name'];
        $source .= '日';
        $tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
        $tcpdf->SetFont("kozgopromedium", "", 9); // 文字の調節
        $source = $attend_cost_array_total[$i]['children_datetime_total'];
        $tcpdf->SetXY(132, $cost_hight_B);
        $tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
        $tcpdf->SetFont("kozgopromedium", "", 10); // 文字の調節
        $source = $attend_cost_array_total[$i]['children_date'];
        $tcpdf->SetXY(167, $cost_hight_B);
        $tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');

    }

}
$source ='延長保育料計';
$tcpdf->SetXY(102, 140);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source = $_POST['attend_cost_total'];
$source .='円';
$tcpdf->SetXY(167, 140);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='諸経費';
$tcpdf->SetXY(5, 145);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->Line(7,152,203,152, array('width' => 0.3));


$costName_width_A = 7;
$costName_width_B = 100;
$costName_hight_A = 146;
$costName_hight_B = 146;
$costValue_width_A = 70;
$costValue_width_B = 167;
$costValue_hight_A = 146;
$costValue_hight_B = 146;


for($i=1; $i<=14; $i++){     //諸経費レイアウト
    $data = $DB->query("SELECT item_id,item_count FROM cost_result WHERE cost_date LIKE '%".$_POST['month']."%' AND children_id = '".$children_id['children_id']."'");
    $item_data = $data->fetchAll();
    $count=$data->rowCount();
    $cost_item = $DB->query("SELECT cost_id,cost_name,price from cost_info where cost_id = '".$i."'");
    $item_count=$cost_item->rowCount();
    $item = $cost_item->fetch();
    if(isset($item['cost_id'])){
        $item_value = 0;
        for($t=0; $t < $count; $t++){
            if($item['cost_id'] == $item_data[$t]['item_id']){
                $item_value = $item_value + $item_data[$t]['item_count'];
            }
        }
    $item_value = $item_value * $item['price'];
    if($i <= 7){
            $source = $item['cost_name'];
            $costName_hight_A = $costName_hight_A + 5;
            $tcpdf->SetXY($costName_width_A, $costName_hight_A);
            $tcpdf->Cell(21,8, $source, 0, 0,'L',0,'',0,0,'T','M');
            $source = $item_value;
            $source .= "円";
            $costValue_hight_A = $costValue_hight_A + 5;
            $tcpdf->SetXY($costValue_width_A, $costValue_hight_A);
            $tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
        }
        if($i > 7){
            $source = $item['cost_name'];
            $costName_hight_B = $costName_hight_B + 5;
            $tcpdf->SetXY($costName_width_B, $costName_hight_B);
            $tcpdf->Cell(21,8, $source, 0, 0,'L',0,'',0,0,'T','M');
            $source = $item_value;
            $source .= "円";
            $costValue_hight_B = $costValue_hight_B + 5;
            $tcpdf->SetXY($costValue_width_B, $costValue_hight_B);
            $tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
        }
    }
}
//$tcpdf->Line(7,183,203,183, array('width' => 0.3));
$source ='諸経費計';
$tcpdf->SetXY(100, 182);
$tcpdf->Cell(21,8, $source, 0, 0,'L',0,'',0,0,'T','M');
$source = $_POST['cost_total'];
$source .='円';
$tcpdf->SetXY(167, 182);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$tcpdf->Line(7,189,203,189, array('width' => 0.3));
$source ='請求合計';
$tcpdf->SetXY(5, 188);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->Line(7,195,203,195, array('width' => 0.3));

$source = $children_id['children_contract_type'];
$source .= '料';
$tcpdf->SetXY(37, 194);
$tcpdf->Cell(21,8, $source, 0, 0,'L',0,'',0,0,'T','M');
$source ='延長保育料';
$tcpdf->SetXY(37, 199);
$tcpdf->Cell(21,8, $source, 0, 0,'L',0,'',0,0,'T','M');
$source ='諸経費';
$tcpdf->SetXY(37, 204);
$tcpdf->Cell(21,8, $source, 0, 0,'L',0,'',0,0,'T','M');
$source ='未入金';
$tcpdf->SetXY(37, 209);
$tcpdf->Cell(21,8, $source, 0, 0,'L',0,'',0,0,'T','M');
$source = $_POST['children_contract_type_total'];
$source .='円';
$tcpdf->SetXY(167, 194);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$source = $_POST['attend_cost_total'];
$source .='円';
$tcpdf->SetXY(167, 199);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$source = $_POST['cost_total'];
$source .='円';
$tcpdf->SetXY(167, 204);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$source = $_POST['not_payment'];
$source .='円';
$tcpdf->SetXY(167, 209);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$tcpdf->Line(7,216,203,216, array('width' => 0.3));
$source ='請求金額';
$tcpdf->SetXY(102, 215);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source = $seikyu_cost_total;
$source .='円';
$tcpdf->SetXY(167, 215);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');

$tcpdf->SetFont("kozgopromedium", "", 8);
$source ='■ご入金について';
$tcpdf->SetXY(12, 219);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='下記指定の口座に振り込みいただくか、当保育園事務室まで直接持参をお願いいたします。';
$tcpdf->SetXY(70, 223);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='埼玉りそな銀行　与野支店（335）普通4657169　ユ）ヴィヴィッド';
$tcpdf->SetXY(59, 227);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='ご入金いただく場合の振込手数料は実費として保護者様に負担いただきます。';
$tcpdf->SetXY(60, 231);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='なお、持参していただく際はお手数おかけしますが、釣銭の無いようお願いいたします。';
$tcpdf->SetXY(69, 235);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='■ご注意ください';
$tcpdf->SetXY(12, 239);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='保育費用の滞納がございますと保育をお受けできない状況となりますのでご注意ください。';
$tcpdf->SetXY(70, 243);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');

$tcpdf->Line(7,249,203,249, array('width' => 0.8));
$source ='保育園　控え';
$tcpdf->SetXY(12, 247.5);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='発行日';
$tcpdf->SetXY(50, 247.5);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source = $today;
$tcpdf->SetXY(80, 247.5);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$tcpdf->Line(7,253.5,203,253.5, array('width' => 0.3));

$source = $children_id['children_contract_type'];
$source .= '料';
$tcpdf->SetXY(37, 252);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='延長保育料';
$tcpdf->SetXY(37, 256);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='諸経費';
$tcpdf->SetXY(37, 260);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source ='未入金';
$tcpdf->SetXY(37, 264);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source = $_POST['children_contract_type_total'];
$source .='円';
$tcpdf->SetXY(167, 252);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$source = $_POST['attend_cost_total'];
$source .='円';
$tcpdf->SetXY(167, 256);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$source = $_POST['cost_total'];
$source .='円';
$tcpdf->SetXY(167, 260);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$source = $_POST['not_payment'];
$source .='円';
$tcpdf->SetXY(167, 264);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$tcpdf->Line(7,270,203,270, array('width' => 0.3));
$source ='請求金額';
$tcpdf->SetXY(102, 268);
$tcpdf->Cell(21,8, $source, 0, 0,'L',0,'',0,0,'T','M');
$source = $seikyu_cost_total;
$source .='円';
$tcpdf->SetXY(167, 268);
$tcpdf->Cell(21,8, $source, 0, 0,'R',0,'',0,0,'T','M');
$source ='振込/現金';
$tcpdf->SetXY(37, 268);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');
$source = $_POST['print_number'];
$tcpdf->SetXY(10, 268);
$tcpdf->Cell(21,8, $source, 0, 0,'C',0,'',0,0,'T','M');





$html = <<< EOF
EOF;
$tcpdf->writeHTML($html); // 表示htmlを設定
ob_end_clean();
$tcpdf->Output($_POST['print_number'].'.pdf', 'I');// pdf表示設定
$tcpdf->setPrintHeader(true);
?>

