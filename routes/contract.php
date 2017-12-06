<?php

use ALImoveis\Models\Login;
use ALImoveis\Models\Contract;
use ALImoveis\Models\Locator;
use ALImoveis\Models\Renter;
use ALImoveis\Models\Immobile;

$app->get('/contract', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $contract = Contract::listAll();

    if (isset($_SESSION['msg'])) {
        $msg = 'class="message '.$_SESSION['msg'].'"';
    } else {
        $msg = NULL;
    }
    unset($_SESSION['msg']);

    $_SESSION['page'] = "contract";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('contract/index.php', array(
        'contract' => $contract,
        'msg' => $msg
    ));
    $app->render('default/footer.php');
});

$app->get('/contract/create', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $codigo = Contract::generateCode();
    $locator = Locator::listAll();
    $renter = Renter::listAll();
    $immobile = Immobile::listAll();

    (isset($_SESSION['data'])) ? $data = $_SESSION['data'] : $data = NULL;
    unset($_SESSION['data']);

    $_SESSION['page'] = "contract";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('contract/create.php', array(
        'codigo' => $codigo,
        'locator' => $locator,
        'renter' => $renter,
        'immobile' => $immobile,
        'data' => $data
    ));
    $app->render('default/footer.php');
});

$app->post('/contract/create', function () {
    Login::verifyLogin();

    $contract = new Contract();
    $contract->setData($_POST);
    $contract->insert();

    header("location: /contract");
    exit;
});

$app->get('/contract/update/:idContract', function ($idContract) use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $contract = Contract::contractId((int) $idContract);
    $locator = Locator::listAll();
    $renter = Renter::listAll();
    $immobile = Immobile::listAll();

    $_SESSION['page'] = "contract";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('contract/update.php', array(
        'contract' => $contract[0],
        'locator' => $locator,
        'renter' => $renter,
        'immobile' => $immobile
    ));
    $app->render('default/footer.php');
});

$app->post('/contract/update/:idContract', function ($idContract) {
    Login::verifyLogin();

    $contract = new Contract();
    $contract->getData((int) $idContract);
    $contract->setData($_POST);
    $contract->update();

    header("location: /contract");
    exit;
});

$app->get('/contract/:idContract/delete', function ($idContract) {
    Login::verifyLogin();
    $contract = new Contract();
    $contract->getData((int) $idContract);
    $contract->delete();

    header("location: /contract");
    exit;
});