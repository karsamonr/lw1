<?php
require_once('../models/TypeList.php');
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$typeList = new TypeList();
if ($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['query'])) {
    $typeList->getBySearchQuery($conn, $_GET['query']);
} else {
    $typeList->getFromDatabase($conn);
}
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $typeData = json_decode(file_get_contents('php://input'), true);
    $typeList->addToDatabase($conn, $typeData);
} else if ($_SERVER['REQUEST_METHOD']=="PUT") {
    $typeData = json_decode(file_get_contents('php://input'), true);
    $typeList->updateDatabaseRow($conn, $typeData);
} else if ($_SERVER['REQUEST_METHOD']=="DELETE") {
    $typeData = json_decode(file_get_contents('php://input'), true);
    $typeList->deleteFromDatabaseByID($conn, $typeData['id']);
};
echo json_encode($typeList->exportAsJSON(), JSON_UNESCAPED_UNICODE);