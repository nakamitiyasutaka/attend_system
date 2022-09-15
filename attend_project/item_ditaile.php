<?php
    if($type=="staff"){
        $title="従業員";
        $attend_column=["出勤","退勤","自動退勤"];
        $column=["staff_id","staff_role","staff_name","staff_name_kana","staff_date_in"];
        $column_name=["ID","役職","名前","カナ","契約日"];
        $new_entry_title = "staff";
        $info_sql = "SELECT * FROM ".$type."_info";
        $column_count = count($column);

    }
    if($type=="noon_staff"){
        $title="従業員";
        $attend_column=["出勤","退勤","自動退勤"];
        $column=["noon_staff_id","noon_staff_role","noon_staff_name","noon_staff_name_kana","noon_staff_date_in"];
        $column_name=["ID","役職","名前","カナ","契約日"];
        $new_entry_title = "staff";
        $info_sql = "SELECT * FROM ".$type."_info";
        $column_count = count($column);

    }
    if($type=="children"){
        $title="園児";
        $attend_column=["登園","降園","自動退勤"];
        $column=[
        "children_id",
        "children_contract_type",
        "children_name",
        "children_name_kana",
        "children_birthday",
        "children_address",
        "children_family",
        "family_level",
        "decrease_tax",

    ];
        $column_name=["ID","保育形態","名前","カナ","誕生日","住所","家族","負担階層","多子軽減額"];
        $info_sql = "SELECT ".$column[0].",".$column[1].",".$column[2].",".$column[3].",".$column[4]." FROM ".$type."_info";
        $column_count = 5;
        $new_entry_title = "children";
        //------------------------園児詳細ページ----------------------------------------------------------
        if(isset($_GET['children_contract_type'])){
            if($_GET['children_contract_type'] == "通常保育"){
                $children_contract_type = [0,0,8000,10000,12500,19500,33000,44000,55000,60000,72800];
            }
            if($_GET['children_contract_type'] == "短縮保育"){
                $children_contract_type = [0,0,7800,9800,12200,19100,32400,43200,54000,58900,71500];
            }
            $int = $_GET['family_level'] - 1;

        }
        if(isset($_GET['decrease_tax'])){
            if($_GET['decrease_tax'] == 1){
                if($_GET['family_level'] == 6){
                    $decrease_tax = 9000;
                }elseif($_GET['family_level'] < 6){
                    $decrease_tax = $children_contract_type[$int] * 0.5;
                }else{
                    $decrease_tax = 0;
                }
            }
            if($_GET['decrease_tax'] == 0){
                $decrease_tax = 0;
            }
        $children_contract_type_total = $children_contract_type[$int] - $decrease_tax;
        }
    
    }
    if($type=="cost"){
        $title="諸経費";
        $column=["cost_id","cost_name","price"];
        $column_name=["ID","名前","値段"];
        $new_entry_title = "staff";
        $info_sql = "SELECT * FROM ".$type."_info";
        $column_count = count($column);
    }
    if($type=="invoice"){
        $title="入金";
        $column=["id","invoice_id","children_id","invoice_datetime","invoice_value"];
        $column_name=["ID","請求書No.","園児id","請求日","金額"];
        $new_entry_title = "";
        $info_sql = "SELECT * FROM ".$type."_info";
        $column_count = count($column);
    }
