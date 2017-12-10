<?php

use ALUImoveis\Models\Login;

$app->get('/login', function () use ($app) {
    $app->render('login/login.php');
});

$app->post('/login', function () use ($app) {
    Login::login($_POST['login'], $_POST['password']);
    header("Location: /");
    exit;
});

$app->get('/logout', function () use ($app) {
    Login::logout();
    $app->render("login/login.php");
});