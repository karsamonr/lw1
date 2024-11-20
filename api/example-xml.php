<?php
require_once('../app/ExampleList.php');
header('Content-Type: text/xml; charset=utf-8');
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$row = false;
$exampleList = new ExampleList();
if (($handle = fopen("../data/examples.csv", "r")) !== false) {
    while (($data = fgetcsv($handle,1000,",")) !== false) {
        if ($row) {
            $exampleList->add(array('example_code'=>$data[0], 'command'=>$data[1]));
        } else 
        $row = true;
    }
    fclose($handle);
    echo $exampleList->exportAsXML();
}