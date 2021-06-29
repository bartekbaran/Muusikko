<?php
$uploadOk = 0;

if(isset($_FILES["fileToUpload"])) {

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check == false) {
            $uploadOk = 1;
        }
    }

        // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 2;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
            $uploadOk = 3;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadOk = 4;
    }

    if ($uploadOk == 0) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            $stmt = $dbh->prepare('UPDATE userInformation SET image = :image WHERE email = :email');
            $stmt->execute([':image' => $file_name, ':email' => $_SESSION['email']]);
            header("Location: https://s120.labagh.pl/home");
            exit();
        } else {
            $uploadOk = 5;
        }
    }
}

echo $twig->render('edit_photo.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'x' => $uploadOk]);