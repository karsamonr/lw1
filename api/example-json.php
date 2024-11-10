<?php
require_once('../app/ExampleList.php');
header('Content-Type: application/json; charset=utf-8');
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$exampleList = new ExampleList();
$exampleList->readFromFile();
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $exampleData = json_decode(file_get_contents('php://input'), true);
    $exampleList->add($exampleData);
    $exampleList->saveToFile();
} else if ($_SERVER['REQUEST_METHOD']=="PUT") {
    $exampleData = json_decode(file_get_contents('php://input'), true);
    $exampleList->update($exampleData);
    $exampleList->saveToFile();
} else if ($_SERVER['REQUEST_METHOD']=="DELETE") {
    $exampleData = json_decode(file_get_contents('php://input'), true);
    $exampleList->delete($exampleData['id']);
    $exampleList->saveToFile();
};
echo json_encode($exampleList->exportAsJSON(), JSON_UNESCAPED_UNICODE);