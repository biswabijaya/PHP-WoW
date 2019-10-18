<?php

/* Function Parameters
  $data = new array(); // array data
  $filepath ; // path with filename
*/

/* Sample Implementation
$data = array (
    'logtype' => 'loginsuccess',
    'timestamp' => date("Y-m-d H:i:s"),
    'user' =>
    array (
      'id' => '1001',
      'usertype' => 'admin',
      'name' => 'Biswa Bijaya Samal',
    ),
  );
$path=$_SERVER['DOCUMENT_ROOT'].'/JsonData/loginlog.json'; //$_SERVER['DOCUMENT_ROOT'] gives the base path to public_html
pushJSON($data,'login');
*/

function pushJSON($data,$filepath) {
  $tmpData = json_decode(file_get_contents($filepath)); //array
  array_push($tmpData, $data); //array
  $json = json_encode($tmpData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); //json
  file_put_contents($filepath, $json);
}


?>
