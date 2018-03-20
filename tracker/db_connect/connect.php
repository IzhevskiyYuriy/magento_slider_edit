<?php
$baseName = 'ronis_tracker';


try {
    $pdo = new PDO(
        'mysql:host=mysql',
        'root',
        'pw',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $sql = "CREATE DATABASE IF NOT EXISTS $baseName";

    $pdo->exec($sql);

    echo "DB created successfully";
}
catch (PDOException $e) {
    echo '<pre>';
    print_r($e);
    echo "Невозможно установить соединение с базой данных";
}