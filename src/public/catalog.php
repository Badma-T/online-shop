<?php

if (!isset($_COOKIE['user_id'])) {
    header(header: "Location: /login_form.php");
}

$pdo = new PDO(dsn:'pgsql:host=db;port=5432;dbname=mydb', username: 'user', password: 'pwd');
$stmt = $pdo->query(query: 'SELECT * FROM products');
$products = $stmt->fetchAll();

require_once './catalog_page.php';
