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
  $data = json_decode(file_get_contents('php://input'));
  if($data['ref'] == 'refs/heads/master'){
    exec('git clone '.$data['repository']['clone_url'].' ts'.time());
    echo '{"response":{"code":200,"status":"OK"}}';
  }
  echo '{"response":{"code":-200,"status":"BAD"}}';
?>
