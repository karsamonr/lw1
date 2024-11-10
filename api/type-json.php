<?php
require_once('../app/TypeList.php');
header('Content-Type: application/json; charset=utf-8');
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$typeList = new TypeList();
$typeList->readFromFile();
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $typeData = json_decode(file_get_contents('php://input'), true);
    $typeList->add($typeData);
    $typeList->saveToFile();
} else if ($_SERVER['REQUEST_METHOD']=="PUT") {
    $typeData = json_decode(file_get_contents('php://input'), true);
    $typeList->update($typeData);
    $typeList->saveToFile();
} else if ($_SERVER['REQUEST_METHOD']=="DELETE") {
    $typeData = json_decode(file_get_contents('php://input'), true);
    $typeList->delete($typeData['id']);
    $typeList->saveToFile();
};
echo json_encode($typeList->exportAsJSON(), JSON_UNESCAPED_UNICODE);