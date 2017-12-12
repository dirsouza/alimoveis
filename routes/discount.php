<?php

use ALUImoveis\Models\Login;
use ALUImoveis\Models\Discount;
use ALUImoveis\Models\Contract;
use ALUImoveis\Models\Portion;

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

    header("location: /discount/create/portion");
    exit;
});

$app->get('/discount/update/:idDiscount', function ($idDiscount) use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $discount = Discount::discountId((int) $idDiscount);
    $contract = Contract::listAll();

    $portion = Portion::portionId((int)$idDiscount);
    if (empty($portion)) {
        $_SESSION['error'] = array(
            'type' => "warning",
            'ico' => "fa-warning",
            'title' => "Aviso",
            'msg' => "Para gerar o desconto, é necessário criar a parcela.<br><b>Clique em&nbsp;<span class='label label-primary'>Atualizar</span>&nbsp;para gerar Parcelas</b>."
        );
    }

    $_SESSION['page'] = "discount";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('discount/update.php', array(
        'discount' => $discount[0],
        'contract' => $contract
    ));
    $app->render('default/footer.php');
});

$app->post('/discount/update/:idDiscount', function ($idDiscount) {
    Login::verifyLogin();

    $discount = new Discount();
    $discount->getData((int) $idDiscount);
    $discount->setData($_POST);
    $discount->update();

    $_SESSION[ALUImoveis\Dao\Dao::SESSION] = (int)$idDiscount;
    header("location: /discount/create/portion");
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

$app->get('/discount/create/portion', function () use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $discount = Discount::discountId($_SESSION[\ALUImoveis\Dao\Dao::SESSION]);
    $contract = Contract::contractId($discount[0]['idContract']);

    $_SESSION['page'] = "discount";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('portion/create.php', array(
        'discount' => $discount[0],
        'contract' => $contract[0]
    ));
    $app->render('default/footer.php');
});

$app->post('/discount/create/portion', function () {
    Login::verifyLogin();
    $idDiscount = $_POST['idDiscount'];
    unset($_POST['idDiscount']);
    $data = $_POST;
    for ($i = 0; $i < count($data['desValue']); $i++) {
        $insert = array(
            'idDiscount' => $idDiscount,
            'desPortion' => (int)$data['desPortion'][$i],
            'dtMaturity' => $data['dtMaturity'][$i],
            'desValue' => $data['desValue'][$i]
        );
        $portion = new Portion();
        $portion->setData($insert);
        $portion->insert();
    }
    header("location: /discount");
    exit;
});