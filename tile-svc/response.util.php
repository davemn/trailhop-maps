<?php
  function _requestStatus($code) {
      $status = array(  
          200 => 'OK',
          400 => 'Bad Request',
          404 => 'Not Found',   
          405 => 'Method Not Allowed',
          500 => 'Internal Server Error',
      ); 
      return ($status[$code])?$status[$code]:$status[500]; 
  }

  function _response($data, $status = 200) {
    header("HTTP/1.1 " . $status . " " . _requestStatus($status));
    echo json_encode($data);
  }
?>