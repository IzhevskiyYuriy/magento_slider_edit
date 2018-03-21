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
}
catch (PDOException $e) {
    echo "Can not connect to database";
}