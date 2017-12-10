<?php

use ALUImoveis\Models\Login;
use ALUImoveis\Models\Immobile;
use ALUImoveis\Models\Nation;
use ALUImoveis\Models\MaritalStatus;

$app->get('/immobile', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $immobile = Immobile::listAll();

    if (isset($_SESSION['msg'])) {
        $msg = 'class="message '.$_SESSION['msg'].'"';
    } else {
        $msg = NULL;
    }
    unset($_SESSION['msg']);

    $_SESSION['page'] = "immobile";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('immobile/index.php', array(
        'immobile' => $immobile,
        'msg' => $msg
    ));
    $app->render('default/footer.php');
});

$app->get('/immobile/create', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $nationality = Nation::listAll();

    $maritalStatus = MaritalStatus::listAll();

    (isset($_SESSION['data'])) ? $data = $_SESSION['data'] : $data = NULL;
    unset($_SESSION['data']);

    $_SESSION['page'] = "immobile";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('immobile/create.php', array(
        'nationality' => $nationality,
        'maritalStatus' => $maritalStatus,
        'data' => $data
    ));
    $app->render('default/footer.php');
});

$app->post('/immobile/create', function () {
    Login::verifyLogin();

    $immobile = new Immobile();
    $immobile->setData($_POST);
    $immobile->insert();

    header("location: /immobile");
    exit;
});

$app->get('/immobile/update/:idImmobile', function ($idImmobile) use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $immobile = Immobile::immobileId((int) $idImmobile);

    $nationality = Nation::listAll();

    $maritalStatus = MaritalStatus::listAll();

    $_SESSION['page'] = "immobile";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('immobile/update.php', array(
        'immobile' => $immobile[0],
        'nationality' => $nationality,
        'maritalStatus' => $maritalStatus
    ));
    $app->render('default/footer.php');
});

$app->post('/immobile/update/:idImmobile', function ($idImmobile) {
    Login::verifyLogin();

    $immobile = new Immobile();
    $immobile->getData((int) $idImmobile);
    $immobile->setData($_POST);
    $immobile->update();

    header("location: /immobile");
    exit;
});

$app->get('/immobile/:idImmobile/delete', function ($idImmobile) {
    Login::verifyLogin();
    $immobile = new Immobile();
    $immobile->getData((int) $idImmobile);
    $immobile->delete();

    header("location: /immobile");
    exit;
});