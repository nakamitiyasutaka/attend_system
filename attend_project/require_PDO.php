<?php
    //phpinfo();
        try{
            $DB = new PDO('mysql:dbname=mydb; host=127.0.0.1;charset=utf8','root');
        }catch(PDOexception $e){
            echo "接続エラー",$e;
        }
        if(isset($_GET['type'])){
        $type=$_GET['type'];
        }
        if(isset($_POST['type'])){
            $type=$_POST['type'];
        }
        
?>
