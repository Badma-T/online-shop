<?php

function validation(array $post, ?PDO $pdo = null): array
{
    $errors = [];

    if (isset($post['name'])) {
        $name = $post['name'];

        if (strlen($name) < 2) {
            $errors['name'] = 'имя должно больше 2';
        }
    } else {
        $errors['name'] = 'Имя должно быть заполнено';
    }

    if (isset($post['email'])) {
        $email = $post['email'];

        if (strlen($email) < 2) {
            $errors['email'] = 'email должен быть больше 2 символов';
        } elseif (filter_var($email, filter: FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'email не корректный';
        } elseif ($pdo !== null) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->fetch()) {
                $errors['email'] = 'Пользователь с таким email уже существует';
            }
        }
    } else {
        $errors['email'] = 'Email должен быть заполнен';
    }

    if (isset($post['psw'])) {
        $password = $post['psw'];
        $passwordRep = $post['psw-repeat'] ?? '';

        if (strlen($password) < 3) {
            $errors['psw'] = 'количество символов меньше 3';
        } elseif ($password !== $passwordRep) {
            $errors['psw-repeat'] = 'пароли не совпадают';
        }
    } else {
        $errors['psw'] = 'Пароль должен быть заполнен';
        $errors['psw-repeat'] = 'Пароль должен быть заполнен';
    }
    return $errors;
}

$pdo = new PDO(dsn:'pgsql:host=db;port=5432;dbname=mydb', username: 'user', password: 'pwd');
$errors = validation($_POST);

if (empty($errors)) {


        $password = password_hash($_POST['psw'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(query: "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $_POST['name'], 'email' => $_POST['email'], 'password' => $password]);

        $stmt = $pdo->prepare(query: "SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $_POST['email']]);

        $data = $stmt->fetch();
        print_r($data);
}

require_once './registration_form.php';
?>




