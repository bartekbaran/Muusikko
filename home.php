<?php

$stmt = $dbh->prepare('SELECT * FROM userInformation WHERE email = :email');
$stmt->execute([':email' => $_SESSION['email']]);
$info_result = $stmt->fetch(PDO::FETCH_ASSOC);

if($info_result['image'] == NULL) {
    $photo = "siema.jpg";
} else {
    $photo = $info_result['image'];
}

$stmt = $dbh->prepare('SELECT * FROM users WHERE email = :email');
$stmt->execute([':email' => $_SESSION['email']]);
$user_result = $stmt->fetch(PDO::FETCH_ASSOC);

$nickname = $user_result['nickname'];
$gender = $info_result['gender'];
$birth = $info_result['birth'];
$city = $info_result['city'];
$description = $info_result['description'];

echo $twig->render('home.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'photo' => $photo, 'nickname' => $nickname, 'gender' => $gender, 'birth' => $birth, 'city' => $city, 'description' => $description, 'email' => $_SESSION['email']]);