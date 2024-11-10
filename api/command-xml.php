<?php
require_once('../app/CommandList.php');
header('Content-Type: text/xml; charset=utf-8');
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$row = false;
$comList = new CommandList();
if (($handle = fopen("../data/commands.csv", "r")) !== false) {
    while (($data = fgetcsv($handle,1000,",")) !== false) {
        if ($row) {
            $comList->add(array('name'=>$data[0], 'description'=>$data[1], 'type'=>$data[2], 'example'=>$data[3]));
        } else
        $row = true;
    }
    fclose($handle);
    echo $comList->exportAsXML();
}