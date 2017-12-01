<?php

use ALImoveis\Models\Login;
use ALImoveis\Models\Locator;

$app->get('/locator', function() use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $locator = Locator::listAll();

    $_SESSION['page'] = "locator";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('locator/index.php', array(
        'locator' => $locator
    ));
    $app->render('default/footer.php');
});

$app->get('/locator/create', function() use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $_SESSION['page'] = "locator";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('locator/create.php');
    $app->render('default/footer.php');
});