<?php
//https://www.devco.net/archives/2005/04/04/openvpn_status_parser_for_php.php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$parsedLog = '';
$key = '';
$keyToMatch = 'l4l4l4l4';
$error = null;

if (isset($_GET['key'])) {
    $key = $_GET['key'];
    if (strcmp($key, $keyToMatch) != 0) {
        $error = new \stdClass();
        $error->status = 'failed';
        $error->message = 'Wrong key';
    }
} else {
    $error = new \stdClass();
    $error->status = 'failed';
    $error->message = 'No key';
}

if ($error == null) {
    include_once 'parser.php';
    $parsedLog = parseLog('openvpn-status.log');

    if ($parsedLog == null) {
        $error = new \stdClass();
        $error->status = 'error';
        $error->message = 'Log error';
    } else {
        $status = array('status' => 'success');
        $parsedLog = $status + $parsedLog;
    }
}

if ($error != null) {
    echo json_encode($error);
} else {
    echo json_encode($parsedLog);
}