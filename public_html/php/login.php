<?php
$flag = false;

if(isset($_SESSION['email'])) {
    header("Location: https://s120.labagh.pl/home");
    exit();
}

if(isset($_POST['loginEmail']) && isset($_POST['psw'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['psw'];

    $stmt = $dbh->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user) {
        if(password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $stmt = $dbh->prepare('SELECT * FROM userInformation WHERE email = :email');
            $stmt->execute([':email' => $email]);
            $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user_info) {
                header("Location: https://s120.labagh.pl/home");
                exit();
            } else {
                header("Location: https://s120.labagh.pl/confirmation");
                exit();
            }
        } else {
            $flag = true; 
        }
    }
}

echo $twig->render('login.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'flag' => $flag]);