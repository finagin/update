<?php
  try {
    $data = json_decode(file_get_contents('php://input'));
    file_put_contents(
      'last/index.html',
      json_encode(
        array(
          'data'    =>  $data->{'repository'}->{'clone_url'},
          'GET'     =>  $_GET,
          'POST'    =>  $_POST,
          'content' =>  $data,
          'date'    =>  time(),
          'server'  =>  $_SERVER
        )
      )
    );
    try {
      if(isset($data) && $data->{'ref'} == 'refs/heads/master'){
        exec('git clone '.$data->{'repository'}->{'clone_url'}.' ts'.time());
      }
    } catch (Exception $e) {
      echo json_encode(
        array(
          'response'  =>  array(
            'code'    =>  199,
            'status'  =>  'BAD',
            'error'   =>  $e
          )
        )
      );
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
