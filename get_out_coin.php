<?php
// 何枚出すか
//
$txt = file_get_contents("/tmp/coin_out");
$out = intval($txt);
$txt = file_get_contents("/tmp/coin_in");
$in = intval($txt);

$bill = 12; // 今までの累算使用電力料金

if ($in > $out) {
    if ($bill > $in) {
        echo 1;
    } else {
        echo $bill - $out;
    }
} else {
    echo 0;
    // すべての家電OFF状態にする
}
