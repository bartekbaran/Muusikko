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

$flag = 0;

if(isset($_POST['editedName']) && isset($_POST['editedGender']) && isset($_POST['editedDay']) && isset($_POST['editedMonth']) && isset($_POST['editedYear']) && isset($_POST['editedCity']) && isset($_POST['editedDesc'])) {

    if($_POST['editedGender'] == "gender") {
        $flag = 1;
    } elseif($_POST['editedMonth'] == "month") {
        $flag = 2;
    }

    if($flag == 0) {
        $birth = "{$_POST['editedDay']} {$_POST['editedMonth']} {$_POST['editedYear']}";

        $stmt = $dbh->prepare('UPDATE users SET nickname = :nickname WHERE email = :email');
        $stmt->execute([':nickname' => $_POST['editedName'], ':email' => $_SESSION['email']]);

        $stmt = $dbh->prepare('UPDATE userMessages SET creator = :newNickname WHERE from_id = :id');
        $stmt->execute([':newNickname' => $_POST['editedName'], ':id' => $_SESSION['id']]);

        $stmt = $dbh->prepare('UPDATE userInformation SET gender = :gender, birth = :birth, city = :city, description = :description WHERE email = :email');
        $stmt->execute([':gender' => $_POST['editedGender'], ':birth' => $birth, ':city' => $_POST['editedCity'], ':description' => $_POST['editedDesc'], ':email' => $_SESSION['email']]);

        header("Location: https://s120.labagh.pl/home");
        exit();
    }
    
}

echo $twig->render('edit_info.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'photo' => $photo, 'nickname' => $nickname, 'gender' => $gender, 'birth' => $birth, 'city' => $city, 'description' => $description, 'flag' => $flag]); 