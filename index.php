<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('FILE_NAME', 'log.txt');

function _log($dataArray){
        file_put_contents(
                FILE_NAME,
                json_encode($dataArray).PHP_EOL,
                FILE_APPEND | LOCK_EX);
}

function proxy(){
$url = "http://109.75.47.45:8080/iguan/rest/mail/resp";
$ch = curl_init($url);

$headers = array('Content-Type: application/json');
// $headers = array('Content-Type: application/x-www-form-urlencoded');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents("php://input"));
curl_setopt($ch, CURLOPT_HEADER, TRUE);

$data = curl_exec($ch);
print_r($headers);
if(curl_errno($ch)){
        exit(curl_error($ch));
}
print_r(file_get_contents("php://input"));
// print_r($data);exit;
exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = file_get_contents("php://input");
        _log(array('date'=>date('Y-m-d h:i:s'), 'POST' => $_POST, 'php://input'=>$data));
        proxy();
}else{
echo "<pre>";
        $tet = array_reverse(explode(PHP_EOL, file_get_contents(FILE_NAME)));
        foreach ($tet as $value) {
                print_r(json_decode($value, true));
                echo PHP_EOL;
        }
}


