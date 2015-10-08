<?php
// コインが出たらリクエストが来る
$txt = file_get_contents("/tmp/coin_out");
$num = intval($txt);
$num += $_GET['reduce'];
file_put_contents("/tmp/coin_out", strval($num));
echo $num;
