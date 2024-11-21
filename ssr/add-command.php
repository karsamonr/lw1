<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
};
require_once('../dbconnect.php');
require_once('../models/CommandList.php');
require_once('../models/TypeList.php');
$comList = new CommandList();
$comList->getFromDatabase($conn);
$typeList = new TypeList();
$typeList->getFromDatabase($conn);
$idContent = '';
$nameContent = '';
$descContent = '';
$typeContent = '';
if (isset($_GET['id'])) {
    $temp = $comList->getItemById($_GET['id']);
    $idContent = $temp['id'];
    $nameContent = $temp['name'];
    $descContent = $temp['description'];
    $typeContent = $temp['type'];
}
if (isset($_POST['name'])) {
    if ($_POST['id'] == '') {
        $comList->addToDatabase($conn, array('name'=>$_POST['name'], 
                    'description'=>$_POST['description'], 
                    'type'=>$_POST['type']));
    } else {
        $comList->updateDatabaseRow($conn, array('id'=>$_POST['id'], 
                    'name'=>$_POST['name'], 
                    'description'=>$_POST['description'], 
                    'type'=>$_POST['type']));
    }
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
        <h1>Додати оператор</h1>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-dark nav-item" href="command-list.php">Список операторів</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="type-list.php">Список типів</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="example-list.php">Список прикладів</a></li>
        </nav>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-outline-dark nav-item" href="add-command.php">Додати оператор</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="add-type.php">Додати тип</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="add-example.php">Додати приклад</a></li>
        </nav>
        <div class="mt-4">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $idContent;?>"/>
                <p><input class="form-input" value="<?php echo $nameContent;?>" name="name" type="text" placeholder="Назва оператора" required/></p>
                <p><input class="form-input" value="<?php echo $descContent;?>" name="description" type="text" placeholder="Опис" required/></p>
                <p>Виберіть тип: <select name="type" required>
                    <?php echo $typeList->exportAsDropdownItems(); ?>
                </select></p>
                <p><button class="btn btn-outline-success" type="submit">Додати</button></p>
            </form>
        </div>
        <a class="btn btn-outline-danger" href="logout.php">Вийти</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>