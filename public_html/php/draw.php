<?php
$email = $_SESSION['email'];

$stmt = $dbh->prepare('SELECT * FROM userInformation WHERE email = :email');
$stmt->execute([':email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$id = 0;
$flag = true;

if($user['status'] == "Band") {
    $pref = "Members";
} else {
    $pref = "Band";
}

if(isset($_GET['index'])) {
    $id = $_GET['index'];
}

if(isset($_GET['add'])) {
    $add = $_GET['add'];

    $stmt = $dbh->prepare('SELECT * FROM userInformation WHERE email = :email');
    $stmt->execute(['email' => $_SESSION['email']]);
    $whole = $stmt->fetch(PDO::FETCH_ASSOC);

    $ids = $whole['added_ids'];
    $newIds = "";

    if($ids == null) {
        $stmt = $dbh->prepare('UPDATE userInformation SET added_ids = :add WHERE email = :email');
        $stmt->execute([':add' => $add, ':email' => $_SESSION['email']]);
    } else {
        $splitted = explode(",", $ids);
        foreach($splitted as &$value) {
            if($newIds == "") {
                $newIds = "{$value}";
            } else {
                $newIds = "{$newIds},{$value}";
            }
            if($add == $value) {
                $flag = false;
            }
        }
        if($flag) {
            $newIds = "{$newIds},{$add}";
            $stmt = $dbh->prepare('UPDATE userInformation SET added_ids = :newIds WHERE email = :email');
            $stmt->execute([':newIds' => $newIds, ':email' => $_SESSION['email']]);
        }
    }

    $flag = true;

    $stmt = $dbh->prepare('SELECT * FROM users WHERE id = :add');
    $stmt->execute([':add' => $add]);
    $whole = $stmt->fetch(PDO::FETCH_ASSOC);

    $addedEmail = $whole['email'];

    $stmt = $dbh->prepare('SELECT * FROM userInformation WHERE email = :email');
    $stmt->execute([':email' => $addedEmail]);
    $wholeInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    $oldIds = $wholeInfo['added_ids'];
    $splittedOldIds = explode(",", $oldIds);
    $newIds = "";

    foreach($splittedOldIds as &$value) {
        if($newIds == "") {
            $newIds = "{$value}";
        } else {
            $newIds = "{$newIds},{$value}";
        }
        if($_SESSION['id'] == $value) {
            $flag = false;
        }
    }

    if($flag) {
        if($newIds == "") {
            $newIds = "{$_SESSION['id']}";
        } else {
            $newIds = "{$newIds},{$_SESSION['id']}";
        }

        $stmt = $dbh->prepare('UPDATE userInformation SET added_ids = :newIds WHERE email = :email');
        $stmt->execute([':newIds' => $newIds, ':email' => $addedEmail]);
    }
}

$stmt = $dbh->prepare('SELECT * FROM userInformation WHERE status = :status');
$stmt->execute([':status' => $pref]);
$info_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(empty($info_result[$id])) {
    header("Location: https://s120.labagh.pl/home");
    exit();
}

if($info_result[$id]['image'] == NULL) {
    $photo = "siema.jpg";
} else {
    $photo = $info_result[$id]['image'];
}

$stmt = $dbh->prepare('SELECT * FROM users WHERE email = :email');
$stmt->execute([':email' => $info_result[$id]['email']]);
$user_result = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare('SELECT * FROM userInformation WHERE email = :email');
$stmt->execute(['email' => $_SESSION['email']]);
$whole = $stmt->fetch(PDO::FETCH_ASSOC);

$ids = $whole['added_ids'];
$splitted = explode(",", $ids);

foreach($splitted as &$value) {
    if($value == $user_result['id']) {
        $id += 1;
        header("Location: https://s120.labagh.pl/draw/skip/{$id}");
        exit();
    }
}

echo $twig->render('draw.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET, 'nickname' => $user_result['nickname'], 'gender' => $info_result[$id]['gender'], 'birth' => $info_result[$id]['birth'], 'city' => $info_result[$id]['city'], 'description' => $info_result[$id]['description'], 'photo' => $photo, 'id' => $id, 'add_id' => $user_result['id']]);