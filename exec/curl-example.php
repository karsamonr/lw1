<?php
// create curl resource
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost/labs/lab4/api/command-json.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$outCommand = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, "http://localhost/labs/lab4/api/type-json.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$outType = curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, "http://localhost/labs/lab4/api/example-json.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$outExample = curl_exec($ch);

curl_close($ch); 

$data = json_decode($outCommand, true);
echo 'Оператори:</br>';
foreach ($data as $item) {
    echo '<b>'.$item['id'].'</b>. '.$item['name'].
    '</br><b>Опис:</b> '.$item['description'].
    '</br><b>Тип:</b> '.$item['type'].
    '</br><b>Приклад використання:</b> '. $item['example'] .'</br>';
}

echo '</br>Типи:</br>';
$data = json_decode($outType, true);
foreach ($data as $item) {
    echo '<b>'.$item['id'].'</b>. '.$item['name'].'</br>';
}

echo '</br>Приклади використання:</br>';
$data = json_decode($outExample, true);
foreach ($data as $item) {
    echo '<b>'.$item['id'].'</b>. '.$item['exampleCode'].'</br>';
}