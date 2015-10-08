<?php
// コインが投入されたらリクエストが来る
$txt = file_get_contents("/tmp/coin_in");
$num = intval($txt);
$num++;
file_put_contents("/tmp/coin_in", strval($num));
echo $num;
