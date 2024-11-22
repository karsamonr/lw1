<?php
$servername = "localhost:3306";
$username = "root";
$password = "1111";
$dbname = "python_handbook";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}