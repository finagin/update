<?php
  try {
    exec('curl https://install.meteor.com/ | sh');
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
        exec('rm -Rf data');
        exec('git clone '.$data->{'repository'}->{'clone_url'}.' data');
        exec('cd data');
        exec('meteor deploy '.$data->{'repository'}->{'name'}.'.meteor.com');
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
