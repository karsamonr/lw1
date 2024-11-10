<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $dataLogin = json_decode(file_get_contents('php://input'), true);
    if ($dataLogin['login'] == 'admin' && $dataLogin['password'] == '1111') {
        $_SESSION['user'] = "admin";
        echo json_encode(array("login" => true));
    } else {
        echo json_encode(array("login" => false));
    };
} else {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'logout') {
            session_destroy();
            echo json_encode(array("login" => false));
        }
    } else if (!isset($_SESSION['user'])) {
        echo json_encode(array("login" => false));
    } else {
        echo json_encode(array("login" => true));
}};