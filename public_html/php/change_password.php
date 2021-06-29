<?php

$flag = 0; 

if(isset($_POST['oldPsw']) && isset($_POST['newPsw']) && isset($_POST['newPswRepeat'])) {

    $stmt = $dbh->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute([':email' => $_SESSION['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user) {
        if(password_verify($_POST['oldPsw'], $user['password'])) {
            if($_POST['newPsw'] == $_POST['newPswRepeat']) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                try {
                    $stmt = $dbh->prepare('UPDATE users SET password = :password WHERE email = :email');
                    $stmt->execute([':password' => $hash, ':email' => $_SESSION['email']]);
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
}

echo $twig->render('change_password.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'flag' => $flag]); 