<?php

$pdo = new PDO(dsn:'pgsql:host=db;port=5432;dbname=mydb', username: 'user', password: 'pwd');

//$pdo->exec(statement:"INSERT INTO users (name, email, password) VALUES ('Pavel', '777ronal@mail.ru', 'qwerty123')");
$statement = $pdo->query(query: "SELECT * FROM users WHERE id = 3");
$data = $statement->fetchAll();
echo "<pre>";
print_r($data);
echo "<pre>";