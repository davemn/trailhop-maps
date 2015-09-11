<?php
  require_once('response.util.php');
  
  // Requests from the same server don't have a HTTP_ORIGIN header
  if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    header("Content-Type: application/json");
    _response(
      array('error' => 'Only requests from localhost allowed'),
      400);
    exit;
  }
  
  header("Access-Control-Allow-Orgin: *");
  header("Access-Control-Allow-Methods: *");
  
  header("Content-Type: image/png");
  
  $packed = $_GET['request'];
  $params = explode('/', $packed);
  
  $zoom = $params[0];
  $x = $params[1];
  $y = $params[2];
  
  // ===
  $doc = "$zoom-$x-$y.png";
  
  header("Content-Disposition: attachment; filename=\"" . $doc . "\"");
  
  # <<<
  # readfile($doc);   # Does not handle large file sizes gracefully
  # ---
  set_time_limit(0);   # potentially dangerous: allows script to run indefinitely
  
  # Chunk the file output to the client
  $f_doc = @fopen($doc,"rb");
  while(!feof($f_doc))
  {
    # Stream 8Mb to the client at a time
    print(@fread($f_doc, 1024*8));
    ob_flush();
    flush();
  }
?>