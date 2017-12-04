<?php

use ALImoveis\Models\Login;
use ALImoveis\Models\Renter;
use ALImoveis\Models\Nation;
use ALImoveis\Models\MaritalStatus;

$app->get('/renter', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $renter = Renter::listAll();

    if (isset($_SESSION['msg'])) {
        $msg = 'class="message '.$_SESSION['msg'].'"';
    } else {
        $msg = NULL;
    }
    unset($_SESSION['msg']);

    $_SESSION['page'] = "renter";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('renter/index.php', array(
        'renter' => $renter,
        'msg' => $msg
    ));
    $app->render('default/footer.php');
});

$app->get('/renter/create', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $nationality = Nation::listAll();

    $maritalStatus = MaritalStatus::listAll();

    (isset($_SESSION['data'])) ? $data = $_SESSION['data'] : $data = NULL;
    unset($_SESSION['data']);

    $_SESSION['page'] = "renter";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('renter/create.php', array(
        'nationality' => $nationality,
        'maritalStatus' => $maritalStatus,
        'data' => $data
    ));
    $app->render('default/footer.php');
});

$app->post('/renter/create', function () {
    Login::verifyLogin();

    $renter = new Renter();
    $renter->setData($_POST);
    $renter->insert();

    header("location: /renter");
    exit;
});

$app->get('/renter/update/:idRenter', function ($idRenter) use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $renter = Renter::renterId((int) $idRenter);

    $nationality = Nation::listAll();

    $maritalStatus = MaritalStatus::listAll();

    $_SESSION['page'] = "renter";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('renter/update.php', array(
        'renter' => $renter[0],
        'nationality' => $nationality,
        'maritalStatus' => $maritalStatus
    ));
    $app->render('default/footer.php');
});

$app->post('/renter/update/:idRenter', function ($idRenter) {
    Login::verifyLogin();

    $renter = new Renter();
    $renter->getData((int) $idRenter);
    $renter->setData($_POST);
    $renter->update();

    header("location: /renter");
    exit;
});

$app->get('/renter/:idRenter/delete', function ($idRenter) {
    Login::verifyLogin();
    $renter = new Renter();
    $renter->getData((int) $idRenter);
    $renter->delete();

    header("location: /renter");
    exit;
});