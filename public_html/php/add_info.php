<?php
$email = $_SESSION['email'];

if(isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year']) && isset($_POST['gender']) && isset($_POST['city']) && isset($_POST['status']) && isset($_POST['description'])) {

    $birth = "{$_POST['day']} {$_POST['month']} {$_POST['year']}";
    $city = $_POST['city'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $gender = $_POST['gender'];

    $stmt = $dbh->prepare('INSERT INTO userInformation (id, email, birth, city, status, description, gender, image) VALUES (null, :email, :birth, :city, :status, :description, :gender, null)');
    $stmt->execute([':email' => $email, ':birth' => $birth, ':city' => $city, ':status' => $status, ':description' => $description, ':gender' => $gender]);

    header("Location: https://s120.labagh.pl/photo_confirm");
    exit();
}

echo $twig->render('add_info.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET]);