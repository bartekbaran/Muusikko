<?php

echo $twig->render('main.twig', ['post' => $_POST, 'session' => $_SESSION, 'get' => $_GET]);