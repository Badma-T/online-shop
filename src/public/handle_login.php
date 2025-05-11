<?php


function validation(string $username, string $password): array
{
    $errors = [];

    if(empty($username)) {
        $errors['username'] = "Email не должен быть пустым";
    } elseif (!filter_var($username, filter: FILTER_VALIDATE_EMAIL)) {
        $errors['username'] = "Некорректный email";
    }

    if (empty($password)) {
        $errors['password'] = "Пароль не может быть пустым";
    }
    return $errors;
}


    $username = $_POST['username'];
    $password = $_POST['password'];

    $errors = validation($username, $password);

if (empty($errors)) {
    $pdo = new PDO(dsn: 'pgsql:host=db;port=5432;dbname=mydb', username: 'user', password: 'pwd');
    $stmt = $pdo->prepare(query: "SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $username]);

    $user = $stmt->fetch();

    $errors = [];
    if ($user === false) {
        $errors['username'] = 'username or password is incorrect';
    } else {
        $passwordDb = $user['password'];

        if(password_verify($password, $passwordDb)) {
            session_start();
            $_SESSION['userId'] = $user['id'];
            $_SESSION['username'] = $username;
            header(header: "Location: /catalog.php");
        } else {
            $errors['username'] = 'username or password is incorrect';
        }
    }
}

require_once './login_form.php';