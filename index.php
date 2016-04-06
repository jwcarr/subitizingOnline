<?php
$data_directory = '~/server_data/sub/';
if ($_GET['pf'] == 'cf' OR $_GET['pf'] == 'mt') {
  $fn = $data_directory . $_GET['pf'] . '/log';
  $fs = filesize($fn);
  if ($fs == 0) { $ip_log = array(); }
  else {
    $fl = fopen($fn, 'r');
    $ip_log = explode("\n", trim(fread($fl, $fs)));
    fclose($fl);
  }
  if (!in_array($_SERVER['REMOTE_ADDR'], $ip_log) AND count($ip_log) < 200) {
    $fl = fopen($fn, 'a+');
    fwrite($fl, $_SERVER['REMOTE_ADDR'] . "\n");
    fclose($fl);
    header('Location: ' . $_GET['pf'] . '.php'); exit;
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <link rel='stylesheet' type='text/css' href='stylesheet.css' />
  <title>How Many Dots?</title>
</head>
<body>
  <div id='complete'>
    <h1>How Many Dots?</h1>
    <p>Sorry, the task is no longer available.</p>
  </div>
</body>
</html>