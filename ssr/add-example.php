<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
};
require_once('../app/ExampleList.php');
$exampleList = new ExampleList();
$exampleList->readFromFile();
$idContent = '';
$codeContent = '';
if (isset($_GET['id'])) {
    $temp = $exampleList->getItemById($_GET['id']);
    $idContent = $temp['id'];
    $codeContent = $temp['exampleCode'];
}
if (isset($_POST['exampleCode'])) {
    if ($_POST['id'] == '') {
        $exampleList->add(array('exampleCode'=>$_POST['exampleCode']));
    } else {
        $exampleList->update(array('id'=>$_POST['id'], 
                    'exampleCode'=>$_POST['exampleCode']));
    }
    $exampleList->saveToFile();
    header('Location: ./example-list.php');
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
        <h1>Додати приклад</h1>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-dark nav-item" href="command-list.php">Список операторів</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="type-list.php">Список типів</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="example-list.php">Список прикладів</a></li>
        </nav>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-dark nav-item" href="add-command.php">Додати оператор</a></li>
            <li class="nav-item"><a class="btn btn-dark nav-item" href="add-type.php">Додати тип</a></li>
            <li class="nav-item"><a class="btn btn-outline-dark nav-item" href="add-example.php">Додати приклад</a></li>
        </nav>
        <div class="mt-4">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $idContent;?>"/>
                <p><input class="form-input" value="<?php echo $codeContent;?>" name="exampleCode" type="text" placeholder="Код прикладу" required/></p>
                <p><button class="btn btn-outline-success" type="submit">Додати</button></p>
            </form>
        </div>
        <a class="btn btn-outline-danger" href="logout.php">Вийти</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>