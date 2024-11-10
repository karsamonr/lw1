<?php
require_once('../app/CommandList.php');
header('Content-Type: application/json; charset=utf-8');
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$comList = new CommandList();
$comList->readFromFile();
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $comData = json_decode(file_get_contents('php://input'), true);
    $comList->add($comData);
    $comList->saveToFile();
} else if ($_SERVER['REQUEST_METHOD']=="PUT") {
    $comData = json_decode(file_get_contents('php://input'), true);
    $comList->update($comData);
    $comList->saveToFile();
} else if ($_SERVER['REQUEST_METHOD']=="DELETE") {
    $comData = json_decode(file_get_contents('php://input'), true);
    $comList->delete($comData['id']);
    $comList->saveToFile();
};
echo json_encode($comList->exportAsJSON(), JSON_UNESCAPED_UNICODE);