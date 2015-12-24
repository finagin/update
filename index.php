<?php
  try {
    $data = json_decode(file_get_contents('php://input'));
    file_put_contents(
      'last/index.html',
      json_encode(
        array(
          'test'    =>  $data['ref'],
          'GET'     =>  $_GET,
          'POST'    =>  $_POST,
          'content' =>  $data,
          'date'    =>  time(),
          'server'  =>  $_SERVER
        )
      )
    );
  
    if(isset($data) && $data['ref'] == 'refs/heads/master'){
      $error = false;
      try {
        exec('git clone '.$data['repository']['clone_url'].' ts'.time());
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
        $error  = true;
      }
      if(!$error){
        echo '{"response":{"code":200,"status":"OK"}}';
      }
    } else {
      echo '{"response":{"code":199,"status":"BAD"}}';
    }
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
