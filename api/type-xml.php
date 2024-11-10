<?php
require_once('../app/TypeList.php');
header('Content-Type: text/xml; charset=utf-8');
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$row = false;
$typeList = new TypeList();
if (($handle = fopen("../data/types.csv", "r")) !== false) {
    while (($data = fgetcsv($handle,1000,",")) !== false) {
        if ($row) {
            $typeList->add(array('name'=>$data[0]));
        } else 
        $row = true;
    }
    fclose($handle);
    echo $typeList->exportAsXML();
}