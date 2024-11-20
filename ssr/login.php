<?php
session_start();
require_once('../app/dbconnect.php');
if (isset($_SESSION['user'])) {
    header('Location:command-list.php');
};
if (isset($_POST['login'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE login = ? AND password = MD5(?);");
    $login = $_POST['login'];
    $password = $_POST['password'];
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $login, $password);
    if ($stmt->num_rows > 0) {
        while ($row = $stmt->fetch()) {
            $_SESSION['user'] = $login;
        }
    }
    $stmt->free_result();
    header('Location:command-list.php');
};
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../assets/style.css" rel="stylesheet"/>
    <title>Python Handbook</title>
</head>
<body>
    <div class="container">
        <h2>Система керування контентом</h2>
        <h1>Вхід</h1>
        <div class="mt-4">
            <form method="POST">
                <p><input class="form-input" name="login" type="text" placeholder="Login" required/></p>
                <p><input class="form-input" name="password" type="password" placeholder="Password" required/></p>
                <p><button class="btn btn-success" type="submit">Вхід</button></p>
            </form>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>