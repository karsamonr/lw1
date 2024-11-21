<?php
require_once('../models/ExampleList.php');
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$exampleList = new ExampleList();
$exampleList->getFromDatabase($conn);
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $exampleData = json_decode(file_get_contents('php://input'), true);
    $exampleList->addToDatabase($conn, $exampleData);
} else if ($_SERVER['REQUEST_METHOD']=="PUT") {
    $exampleData = json_decode(file_get_contents('php://input'), true);
    $exampleList->updateDatabaseRow($conn, $exampleData);
} else if ($_SERVER['REQUEST_METHOD']=="DELETE") {
    $exampleData = json_decode(file_get_contents('php://input'), true);
    $exampleList->deleteFromDatabaseByID($conn, $exampleData['id']);
};
echo json_encode($exampleList->exportAsJSON(), JSON_UNESCAPED_UNICODE);