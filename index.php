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
  if(isset($data) && $data['ref'] == 'refs/heads/master'){
    exec('git clone '.$data['repository']['clone_url'].' ts'.time());
    echo '{"response":{"code":200,"status":"OK"}}';
    exit();
  }
  echo '{"response":{"code":199,"status":"BAD"}}';
?>
