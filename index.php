<?php
  try {
    $data = json_decode(file_get_contents('php://input'));
    file_put_contents(
      'last/index.html',
      json_encode(
        array(
          'data'    =>  $data->{'ref'},
          'GET'     =>  $_GET,
          'POST'    =>  $_POST,
          'content' =>  $data,
          'date'    =>  time(),
          'server'  =>  $_SERVER
        )
      )
    );
    echo json_encode(array('code' =>  200));
  } catch (Exception $e) {
    echo json_encode(
      array(
        'response'  =>  array(
          'code'    =>  198,
          'status'  =>  'BAD',
          'error'   =>  $e
        )
      )
    );
  }
?>
