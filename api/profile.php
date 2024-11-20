<?php
header('Content-Type: application/json; charset=utf-8');
require_once('../app/dbconnect.php');
session_start();
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $dataLogin = json_decode(file_get_contents('php://input'), true);
    if (isset($dataLogin['login'])) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE login = ? AND password = MD5(?);");
        $login = $dataLogin['login'];
        $password = $dataLogin['password'];
        $stmt->bind_param("ss", $login, $password);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $login, $password);
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch()) {
                $_SESSION['user'] = $login;
            }
            echo json_encode(array("login" => true));
        } else {
            echo json_encode(array("login" => false));
        }
        $stmt->free_result();
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