<?php
$data_directory = '~/server_data/sub/';
if ($_GET['submit'] == 'true') { $submit = True; } else { $submit = False; }
if ($submit == True) {
  $id = $_GET['id'];
  if (strlen($id) < 5 OR strlen($id) > 30) {
    header('Location: index.php'); exit;
  }
  $fn = $data_directory . 'mt/' . $id;
  if (file_exists($fn)) {
    $file = fopen($fn, 'r');
    $content = fread($file, filesize($fn));
    $lines = explode("\n", $content);
    $first = explode("\t", $lines[0]);
    $code = $first[0];
  }
  else {
    $targets = json_decode($_GET['targets']);
    $responses = json_decode($_GET['responses']);
    $reactions = json_decode($_GET['reactions']);
    if (count($targets) != 45 OR count($responses) != 45 OR count($reactions) != 45) {
      header('Location: index.php'); exit;
    }
    $letters1 = array('B', 'C', 'D', 'E', 'F', 'G', 'H');
    $letters2 = array('K', 'L', 'M', 'N', 'P', 'Q', 'R');
    $letters3 = array('T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $code = rand(1, 5) . $letters1[rand(0, 6)] . rand(3, 7) . $letters2[rand(0, 6)] . rand(5, 9) . $letters3[rand(0, 6)] . rand(100, 999);
    $csv = $code . "\t" . $_SERVER['REMOTE_ADDR'] . "\t" . time() . "\n";
    for ($i=0; $i<45; $i++) {
      $csv .= $targets[$i] . "\t" . $responses[$i] . "\t" . $reactions[$i] . "\n";
    }
    $file = fopen($fn, 'w+');
    fwrite($file, trim($csv));
  }
  fclose($file);
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
  <?php if ($submit == True) { echo "
  <div id='complete'>
    <h1>How Many Dots?</h1>
    <p>Thank you! The task is now complete. If you have any questions about this study, please contact j.w.carr@ed.ac.uk</p>
  </div>"; }
  else { echo "
  <div id='entry'>
    <p>Please enter your Mechanical Turk Worker ID</p>
    <p>&nbsp;</p>
    <input type='text' id='id' autocomplete='off' maxlength='16' />
    <p>&nbsp;</p>
    <button id='enter_experiment'>NEXT</button>
  </div>
  <div id='instructions' style='visibility: hidden;'>
    <h1>How Many Dots?</h1>
    <p>We will flash dots on the screen very quickly. Your task is to estimate how many dots appeared and press the corresponding number on your keyboard. <strong>You should respond as <u>quickly</u> and as <u>accurately</u> as possible.</strong></p>
    <p>The dots will flash up very quickly, so please pay close attention to the screen. <strong>The number of dots is always between 1 and 9.</strong> Keep your fingers near the number keys so that you can press them as quickly as possible.</p>
    <p>The task takes about 1 minute to complete.</p>
    <p>&nbsp;</p>
    <img src='demo.jpg' width='700' height='200' />
    <p>&nbsp;</p>
    <button id='start_experiment'>START</button>
  </div>
  <div id='experiment' style='visibility: hidden;'>
    <canvas id='stimulus_canvas' width='500' height='500'></canvas>
  </div>
  <script type='text/javascript' src='jquery-2.1.4.js'></script>
  <script type='text/javascript' src='client.js'></script>"; } ?>
</body>
</html>