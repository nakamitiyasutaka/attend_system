<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php $int_1 =3;?>
    <input type="number" name="number1" value="">
    <input type="button"name="test" value="test" onclick="clickBtn1(this.number1.value)">
    <form id="p1">
    <?php for($i=0 ; $i < $int_1 ; $i++):?>
        <input type="text">
    <?php endfor;?>
    </form>
    <div id="text-button1" onclick="clickDisplayAlert(<?php print($int_1);?>)">Click1</div>
    <div id="text-button2" onclick="clickDisplayAlert(2)">Click2</div>
    <p id="test">aaaa</p>
    <p id="test2">練習２</p>
    <p onclick="console.log('クリックされました')">クリックしてconsole.logを見てください。</p>
    <p id="test3">練習３</p>
    <p id="test4">練習４</p>
    
    <button onclick="countUp01();">追加ボタン</button>
    <button onclick="countUp02();">減少ボタン</button>
    <span id = "sampleOutput01">0</span>
    <p id = "addForm">フォームが表示されます。</p>


    <div id ="form_area02"><div id = "form_area"></div></div>
    <input type="button" value = "フォーム追加" onclick="addForm()">

    <script>
        document.getElementById("p1").style.display ="none";
        function clickBtn1(){
            const p1 = document.getElementById("p1");

            if(p1.style.display=="block"){
                p1.style.display="none";
            }else{
                p1.style.display="block";

            }
        }

        function clickDisplayAlert(num){
            if(num === 3){
                    alert("phpのボタンがクリック");
            }else{
                alert("２のボタンがクリック");
            }
        }

        var a =[];
        a[0] ="hellow";
        a[1] ="world";
        console.log(a);

        var b = new Array(1,2,3,4);
        console.log(b);
        document.getElementById("test").style.color="red";
        document.getElementById("test").style.backgroundColor="black";
        var hoge = document.getElementById("test2");
        hoge.innerHTML ="<span style='color:red'>変更しましたよ！！！</span>";
        function addition(x){
            var y;
            y = x +1;
            console.log(y+"が出力されました。");
        }
        addition(10);
        function textColor_1(id,font_color){
            document.getElementById(id).style.color = font_color;

        }
        var change01 = document.getElementById("test3");
        change01.onmouseover = function(){
            console.log("出力１");
        }
        change01.onmouseout = function(){
            console.log('出力２');
            console.log('出力３');
        }

        var change02 = document.getElementById("test4");
        change02.addEventListener("click",function(){
            alert('hoge11');
        },false);
        change02.addEventListener("click",function(){
            alert('hoge22');
        },false);
        window.addEventListener("load",function(){
            alert("DOMの読み込み完了です。");
        });




        var i = 1;
        function addForm(){
            for(var cnt = 0 ; cnt < 4; cnt++){
                var input_data =  document.createElement('input');
                input_data.type = 'text';
                input_data.id = 'inputform_' + i;
                input_data.placeholder = 'フォーム-' + i;
                var parent = document.getElementById('form_area');
                parent.appendChild(input_data);
                input_data02 = document.createElement('br');
                parent02 = document.getElementById('form_area02');
                parent02.appendChild(input_data02);
            }
            i++;

        }
        
        </script>

</body>
</html>