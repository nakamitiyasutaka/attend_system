function Check1() {
    var checked = confirm("本当に修正しますか？");
    if (checked == true) {
        return true;
    } else {
        return false;
    }
}

function Check2() {
    var checked = confirm("本当に削除しますか？");
    if (checked == true) {
        return true;
    } else {
        return false;
    }
}

function Check3() {
    var checked = confirm("本当に新規追加しますか？");
    if (checked == true) {
        return true;
    } else {
        return false;
    }
}

function set2fig(num) {
    // 桁数が1桁だったら先頭に0を加えて2桁に調整する
    var ret;
    if (num < 10) { ret = "0" + num; } else { ret = num; }
    return ret;
}

function showClock2() {
    var nowTime = new Date();
    var nowHour = set2fig(nowTime.getHours());
    var nowMin = set2fig(nowTime.getMinutes());
    var nowSec = set2fig(nowTime.getSeconds());
    var msg = nowHour + ":" + nowMin + ":" + nowSec;
    document.getElementById("RealtimeClockArea2").innerHTML = msg;
}

function showClock3() {
    console.log("出力1");
}
setInterval('showClock2()', 1000);
setInterval('showClock3()', 5000);