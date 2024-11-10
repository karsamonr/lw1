<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../CommandList.php');
require_once('../ExampleList.php');
require_once('../TypeList.php');

echo 'Оператори:</br>';
$row = false;
$comList = new CommandList();
if (($handle = fopen("../data/commands.csv", "r")) !== false) {
    while (($data = fgetcsv($handle,1000,",")) !== false) {
        if ($row) {
            $comList->add(array('name'=>$data[0], 'description'=>$data[1], 'type'=>$data[2], 'example'=>$data[3]));
        } else
        $row = true;
    }
    fclose($handle);
    $comList->displayInfo();
}
$fp = fopen('../data/commands.csv', 'w');
foreach ($comList->exportAsArray() as $item) {
    fputcsv($fp, $item);
}
fclose($fp);

echo '</br>Типи:</br>';
$row = false;
$typeList = new TypeList();
if (($handle = fopen("../data/types.csv", "r")) !== false) {
    while (($data = fgetcsv($handle,1000,",")) !== false) {
        if ($row) {
            $typeList->add(array('name'=>$data[0]));
        } else 
        $row = true;
    }
    fclose($handle);
    $typeList->displayInfo();
}
$fp = fopen('../data/types.csv', 'w');
foreach ($typeList->exportAsArray() as $item) {
    fputcsv($fp, $item);
}
fclose($fp);

echo '</br>Приклади використання:</br>';
$row = false;
$exampleList = new ExampleList();
if (($handle = fopen("../data/examples.csv", "r")) !== false) {
    while (($data = fgetcsv($handle,1000,",")) !== false) {
        if ($row) {
            $exampleList->add(array('exampleCode'=>$data[0]));
        } else
        $row = true;
    }
    fclose($handle);
    $exampleList->displayInfo();
}
$fp = fopen('../data/examples.csv', 'w');
foreach ($exampleList->exportAsArray() as $item) {
    fputcsv($fp, $item);
}
fclose($fp);