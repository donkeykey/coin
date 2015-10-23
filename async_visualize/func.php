<?php
  $conn = "host=localhost dbname=zeh_locate user=kpj password=znh1sge";
  $link = pg_connect($conn);
  if (!$link) {
    die('DBへの接続に失敗しました'.pg_last_error());
  }
  pg_set_client_encoding("UTF8");
  $sql = "SELECT x, y, mets FROM location WHERE date > '2014-11-01' ORDER BY date desc LIMIT 1;";
  echo "$sql<br>\n";
  $result = pg_query($sql);

  if (!$result) {
    die('SELECTに失敗しました'.pg_last_error());
  }

  $rows = pg_fetch_array($result, 0, PGSQL_NUM);
  echo "x:$rows[0]<br>\n";
  echo "y:$rows[1]<br>\n";
  echo "mets:$rows[2]<br>\n";


  $close_flag = pg_close($link);

  if ($close_flag) {
    $end = "ok";
    return $end;
  }
?>
