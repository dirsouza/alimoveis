<?php

use ALUImoveis\Models\Login;
use ALUImoveis\Models\Contract;
use ALUImoveis\Models\Receipt;

$app->get('/receipt', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $receipt = Receipt::listAll();

    if (isset($_SESSION['msg'])) {
        $msg = 'class="message '.$_SESSION['msg'].'"';
    } else {
        $msg = NULL;
    }
    unset($_SESSION['msg']);

    $_SESSION['page'] = "receipt";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('receipt/index.php', array(
        'receipt' => $receipt,
        'msg' => $msg
    ));
    $app->render('default/footer.php');
});

$app->get('/receipt/create', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $codigo = Receipt::generateCode();
    $contract = Contract::listAll();
    $month = Receipt::month();

    (isset($_SESSION['data'])) ? $data = $_SESSION['data'] : $data = NULL;
    unset($_SESSION['data']);

    $_SESSION['page'] = "receipt";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('receipt/create.php', array(
        'codigo' => $codigo,
        'contract' => $contract,
        'month' => $month,
        'data' => $data
    ));
    $app->render('default/footer.php');
});

$app->post('/receipt/create', function () {
    Login::verifyLogin();

    $receipt = new Receipt();
    $receipt->setData($_POST);
    $receipt->insert();

    header("location: /receipt");
    exit;
});

$app->get('/receipt/update/:idReceipt', function ($idReceipt) use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $receipt = Receipt::receiptId((int) $idReceipt);
    $locator = Locator::listAll();
    $renter = Renter::listAll();
    $immobile = Immobile::listAll();

    $_SESSION['page'] = "receipt";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('receipt/update.php', array(
        'receipt' => $receipt[0],
        'locator' => $locator,
        'renter' => $renter,
        'immobile' => $immobile
    ));
    $app->render('default/footer.php');
});

$app->post('/receipt/update/:idReceipt', function ($idReceipt) {
    Login::verifyLogin();

    $receipt = new Receipt();
    $receipt->getData((int) $idReceipt);
    $receipt->setData($_POST);
    $receipt->update();

    header("location: /receipt");
    exit;
});

$app->get('/receipt/:idReceipt/delete', function ($idReceipt) {
    Login::verifyLogin();
    $receipt = new Receipt();
    $receipt->getData((int) $idReceipt);
    $receipt->delete();

    header("location: /receipt");
    exit;
});

$app->get('/receipt/contract/:desCode', function ($desCode) use ($app) {
    Login::verifyLogin();

    $contract = Contract::viewContract($desCode);
    $locator = Locator::locatorDetails($contract['idLocator']);
    $renter = Renter::renterDetails($contract['idRenter']);
    $immobile = Immobile::immobileId($contract['idImmobile']);
    $valueFull = GExtenso::moeda(preg_replace('/[.,]/', "",number_format($contract['desValue'], 2, ",", ".")));
    $mesFull = GExtenso::numero($contract['desDeadline']);
    $dateFull = GExtenso::numero(preg_replace('/[0]/', "", date('d', strtotime($contract['dtInitial']))));
    $app->render('/contract/contract.php', array(
        'contract' => $contract,
        'locator' => $locator,
        'renter' => $renter,
        'immobile' => $immobile[0],
        'valueFull' => $valueFull,
        'mesFull' => $mesFull,
        'dateFull' => $dateFull
    ));
});