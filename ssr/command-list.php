<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
};
require_once('../dbconnect.php');
require_once('../models/CommandList.php');
$comList = new CommandList();
//$comList->getFromDatabase($conn);
if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    $comList->deleteFromDatabaseByID($conn, $_GET['id']);
    header('Location: ./command-list.php');
}
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
        <h1>Список операторів</h1>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-outline-dark nav-item" href="command-list.php">Список операторів</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="type-list.php">Список типів</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="example-list.php">Список прикладів</a></li>
        </nav>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-dark nav-item" href="add-command.php">Додати оператор</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="add-type.php">Додати тип</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="add-example.php">Додати приклад</a></li>
        </nav>
        <form action="./command-list.php" method="GET">
            <input type="search" name="query" required/>
            <input type="submit" value="Пошук"/>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Назва</th>
                    <th>Опис</th>
                    <th>Тип</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['query'])) {
                        $comList->getBySearchQuery($conn, $_GET['query']);
                    } else {
                        $comList->getFromDatabase($conn);
                    }
                    echo $comList->exportAsTableData(); 
                ?>
            </tbody>
        </table>
        <a class="btn btn-outline-danger" href="logout.php">Вийти</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>