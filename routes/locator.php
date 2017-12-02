<?php

use ALImoveis\Models\Login;
use ALImoveis\Models\Locator;
use ALImoveis\Models\Nation;
use ALImoveis\Models\MaritalStatus;

$app->get('/locator', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $locator = Locator::listAll();

    if (isset($_SESSION['msg'])) {
        $msg = 'class="message '.$_SESSION['msg'].'"';
    } else {
        $msg = NULL;
    }
    unset($_SESSION['msg']);

    $_SESSION['page'] = "locator";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('locator/index.php', array(
        'locator' => $locator,
        'msg' => $msg
    ));
    $app->render('default/footer.php');
});

$app->get('/locator/create', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $nationality = Nation::listAll();

    $maritalStatus = MaritalStatus::listAll();

    (isset($_SESSION['data'])) ? $data = $_SESSION['data'] : $data = NULL;
    unset($_SESSION['data']);

    $_SESSION['page'] = "locator";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('locator/create.php', array(
        'nationality' => $nationality,
        'maritalStatus' => $maritalStatus,
        'data' => $data
    ));
    $app->render('default/footer.php');
});

$app->post('/locator/create', function () {
    Login::verifyLogin();

    $locator = new Locator();
    $locator->setData($_POST);
    $locator->insert();

    header("location: /locator");
    exit;
});

$app->get('/locator/update/:idLocator', function ($idLocator) use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $locator = Locator::locatorId((int) $idLocator);

    $nationality = Nation::listAll();

    $maritalStatus = MaritalStatus::listAll();

    $_SESSION['page'] = "locator";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('locator/update.php', array(
        'locator' => $locator[0],
        'nationality' => $nationality,
        'maritalStatus' => $maritalStatus
    ));
    $app->render('default/footer.php');
});

$app->post('/locator/update/:idLocator', function ($idLocator) {
    Login::verifyLogin();

    $locator = new Locator();
    $locator->getData((int) $idLocator);
    $locator->setData($_POST);
    $locator->update();

    header("location: /locator");
    exit;
});

$app->get('/locator/:idLocator/delete', function ($idLocator) {
    Login::verifyLogin();
    $locator = new Locator();
    $locator->getData((int) $idLocator);
    $locator->delete();

    header("location: /locator");
    exit;
});