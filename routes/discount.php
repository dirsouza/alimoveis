<?php

use ALImoveis\Models\Login;
use ALImoveis\Models\Discount;
use ALImoveis\Models\Contract;

$app->get('/discount', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $discount = Discount::listAll();

    $totalValues = 0;
    foreach ($discount as $index) {
        $totalValues += $index['desValue'];
    }

    if (isset($_SESSION['msg'])) {
        $msg = 'class="message '.$_SESSION['msg'].'"';
    } else {
        $msg = NULL;
    }
    unset($_SESSION['msg']);

    $_SESSION['page'] = "discount";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('discount/index.php', array(
        'discount' => $discount,
        'msg' => $msg,
        'totalValues' => $totalValues
    ));
    $app->render('default/footer.php');
});

$app->get('/discount/create', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $contract = Contract::listAll();

    (isset($_SESSION['data'])) ? $data = $_SESSION['data'] : $data = NULL;
    unset($_SESSION['data']);

    $_SESSION['page'] = "discount";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('discount/create.php', array(
        'contract' => $contract,
        'data' => $data
    ));
    $app->render('default/footer.php');
});

$app->post('/discount/create', function () {
    Login::verifyLogin();

    $discount = new Discount();
    $discount->setData($_POST);
    $discount->insert();

    header("location: /discount");
    exit;
});

$app->get('/discount/update/:idDiscount', function ($idDiscount) use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $discount = Discount::discountId((int) $idDiscount);

    $nationality = Nation::listAll();

    $maritalStatus = MaritalStatus::listAll();

    $_SESSION['page'] = "discount";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('discount/update.php', array(
        'discount' => $discount[0],
        'nationality' => $nationality,
        'maritalStatus' => $maritalStatus
    ));
    $app->render('default/footer.php');
});

$app->post('/discount/update/:idDiscount', function ($idDiscount) {
    Login::verifyLogin();

    $discount = new Discount();
    $discount->getData((int) $idDiscount);
    $discount->setData($_POST);
    $discount->update();

    header("location: /discount");
    exit;
});

$app->get('/discount/:idDiscount/delete', function ($idDiscount) {
    Login::verifyLogin();
    $discount = new Discount();
    $discount->getData((int) $idDiscount);
    $discount->delete();

    header("location: /discount");
    exit;
});