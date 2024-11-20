<?php
require_once('../app/dbconnect.php');
require_once('../app/CommandList.php');
header('Content-Type: application/json; charset=utf-8');
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$comList = new CommandList();
$comList->getFromDatabase($conn);
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $comData = json_decode(file_get_contents('php://input'), true);
    $comList->addToDatabase($conn, $comData);
} else if ($_SERVER['REQUEST_METHOD']=="PUT") {
    $comData = json_decode(file_get_contents('php://input'), true);
    $comList->updateDatabaseRow($conn, $comData);
} else if ($_SERVER['REQUEST_METHOD']=="DELETE") {
    $comData = json_decode(file_get_contents('php://input'), true);
    $comList->deleteFromDatabaseByID($conn, $comData['id']);
};
echo json_encode($comList->exportAsJSON(), JSON_UNESCAPED_UNICODE);