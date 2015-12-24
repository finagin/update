<?php
  file_put_contents(
    'last/index.html',
    json_encode(
      array(
        'GET'     =>  $_GET,
        'POST'    =>  $_POST,
        'content' =>  json_decode(
          file_get_contents('php://input')
        ),
        'date'    =>  time(),
        'server'  =>  $_SERVER
      )
    )
  );
?>
