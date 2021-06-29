<?php
$flag = 0; 

if(isset($_POST['nickname'])  && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['psw-repeat'])) {

    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pswrepeat = $_POST['psw-repeat'];

    if($password == $pswrepeat) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if(preg_match('/^[a-zA-Z0-9\-\_\.]+\@[a-zA-Z0-9\-\_\.]+\.[a-zA-Z]{2,5}$/D', $email)) {
            try {
                $stmt = $dbh->prepare('INSERT INTO users (id, email, nickname, password, created) VALUES (null, :email, :nickname, :password, NOW())');
                $stmt->execute([':email' => $email, ':nickname' => $nickname, 'password' => $hashedPassword]);

                $stmt = $dbh->prepare('SELECT * FROM users WHERE email = :email');
                $stmt->execute([':email' => $email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                header("Location: https://s120.labagh.pl/login");
                exit();
            } catch (PDOException $e) {
                $flag = 1;
            }
        } else {
            $flag = 2;
        }
    } else {
        $flag = 3;
    }
}

echo $twig->render('register.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'flag' => $flag]);