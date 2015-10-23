<?php
  $conn = "host=localhost dbname=zeh_locate user=kpj password=znh1sge";
  //$conn = "host=zeh.west.sd.keio.ac.jp dbname=zeh_locate user=kpj password=znh1sge";
  $link = pg_connect($conn);
  if (!$link) {
    die('DBへの接続に失敗しました'.pg_last_error());
  }
  pg_set_client_encoding("UTF8");
  $sql = "SELECT x, y, mets FROM location WHERE date > '2014-11-01' ORDER BY date desc LIMIT 1;";
  //$sql = "SELECT x, y, mets FROM location WHERE date > '2014-11-01' AND id='tc' ORDER BY date desc LIMIT 1;";
  //echo "$sql<br>\n";
  $result = pg_query($sql);

  if (!$result) {
    die('SELECTに失敗しました'.pg_last_error());
  }

  $rows = pg_fetch_array($result, 0, PGSQL_NUM);
  //echo "最新値<br>\n";
  $arr = array(
  	"x" => $rows[0],
  	"y" => $rows[1],
  	"mets" => $rows[2],
  );

  $json = json_encode($arr);

  echo $json;

  $close_flag = pg_close($link);

  //if ($close_flag) {
    //$end = "ok";
    //return $end;
  //}
?>
