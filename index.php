<?php
require __DIR__ . '/vendor/autoload.php';

include("config.inc.php");

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

$allowed_pages = ['main', 'register', 'login', 'home', 'draw', 'general', 'add_photo', 'add_info', 'photo_confirm', 'confirmation', 'edit_info', 'logout', 'edit_photo', 'change_password', 'chat', 'search'];
$protected_pages = ['home', 'draw', 'change_password', 'add_photo', 'add_info', 'photo_confirm', 'confirmation', 'edit_info', 'edit_photo', 'chat', 'search'];

ini_set('display_errors', 1);
error_reporting(E_ALL);
define("IN_INDEX", 1);
session_start();

if (isset($config) && is_array($config)) {

    try {
        $dbh = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8mb4', $config['db_user'], $config['db_password']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "Nie mozna polaczyc sie z baza danych: " . $e->getMessage();
        exit();
    }

} else {
    exit("Nie znaleziono konfiguracji bazy danych.");
}

if(isset($_GET['page']) && in_array($_GET['page'], $allowed_pages)) {
    if(!file_exists(__DIR__ . '/php/' . $_GET['page'] . '.php')) {
        echo $twig->render($_GET['page'] . '.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET]);
    } elseif(in_array($_GET['page'], $protected_pages)) {
        if(isset($_SESSION['email'])) {
            include(__DIR__ . '/php/' . $_GET['page'] . '.php');
        } else {
            header("Location: https://s120.labagh.pl/login");
            exit();
        }
    } else {
        include(__DIR__ . '/php/' . $_GET['page'] . '.php');
    }
} else {
    include(__DIR__ . '/php/main.php');
}

include("functions.inc.php");
?>