<?php

$flag = false;

if(isset($_POST['search'])) {
    $stmt = $dbh->prepare('SELECT * FROM users WHERE nickname = :nickname');
    $stmt->execute([':nickname' => $_POST['search']]);
    $userResult = $stmt->fetch(PDO::FETCH_ASSOC);

    if($userResult != null) {
        $stmt = $dbh->prepare('SELECT * FROM userInformation WHERE email = :email');
        $stmt->execute([':email' => $userResult['email']]);
        $userInfoResult = $stmt->fetch(PDO::FETCH_ASSOC);

        $flag = true;
    }
}

if($flag) {
    if($userInfoResult['image'] == null) {
        $photo = "siema.jpg";
    } else {
        $photo = $userInfoResult['image'];
    }

    echo $twig->render('search.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'image' => $photo, 'nickname' => $userResult['nickname'], 'gender' => $userInfoResult['gender'], 'birth' => $userInfoResult['birth'], 'city' => $userInfoResult['city'], 'description' => $userInfoResult['description'], 'flag' => $flag]);
} else {
    echo $twig->render('search.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'flag' => $flag]);
}