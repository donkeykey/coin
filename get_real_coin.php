<?php
// 今実際にいくら入っているのか（あといくら使えるか）
// たぶんアプリ表示用
$txt = file_get_contents("/tmp/coin_out");
$out = intval($txt);
$txt = file_get_contents("/tmp/coin_in");
$in = intval($txt);
echo $in - $out;
