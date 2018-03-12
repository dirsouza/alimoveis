<?php

use ALUImoveis\Models\GExtenso;
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
    $_SESSION['type'] = "create";

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

    (isset($_SESSION['data'])) ? $data = $_SESSION['data'] : $data = NULL;
    unset($_SESSION['data']);

    $_SESSION['page'] = "receipt";
    $_SESSION['type'] = "create";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('receipt/create.php', array(
        'codigo' => $codigo,
        'contract' => $contract,
        'data' => $data
    ));
    $app->render('default/footer.php');
});

$app->post('/receipt/create', function () {
    Login::verifyLogin();

    if (array_key_exists("desPortions", $_POST)) {
        $portions = null;
        foreach ($_POST['desPortions'] as $value) {
            if(end($_POST['desPortions']) === $value) {
                $portions .= $value;
            } else {
                $portions .= $value.",";
            }
        }
        $_POST['desPortions'] = $portions;
    } else {
        $_POST['desPortions'] = null;
    }

    if (array_key_exists("desFined", $_POST)) {
        if ($_POST['desFined'] === "") {
            $_POST['desFined'] = 0;
        }
    }

    if (array_key_exists("desInterest", $_POST)) {
        if ($_POST['desInterest'] === "") {
            $_POST['desInterest'] = 0;
        }
    }

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
    $contract = Contract::listAll();
    $portions = Receipt::searchPortions($contract[0]['idContract']);

    $_SESSION['page'] = "receipt";
    $_SESSION['type'] = "update";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('receipt/update.php', array(
        'receipt' => $receipt[0],
        'contract' => $contract[0],
        'portions' => $portions
    ));
    $app->render('default/footer.php');
});

$app->post('/receipt/update/:idReceipt', function ($idReceipt) {
    Login::verifyLogin();

    if (array_key_exists("desPortions", $_POST)) {
        $portions = null;
        foreach ($_POST['desPortions'] as $value) {
            if(end($_POST['desPortions']) === $value) {
                $portions .= $value;
            } else {
                $portions .= $value.",";
            }
        }
        $_POST['desPortions'] = $portions;
    } else {
        $_POST['desPortions'] = null;
    }

    if (array_key_exists("desFined", $_POST)) {
        if ($_POST['desFined'] === "") {
            $_POST['desFined'] = 0;
        }
    }

    if (array_key_exists("desInterest", $_POST)) {
        if ($_POST['desInterest'] === "") {
            $_POST['desInterest'] = 0;
        }
    }

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

$app->get('/receipt/consulting/contract/:idContract', function($idContract) use ($app) {
    Login::verifyLogin();

    $contract = Contract::contractId($idContract);
    $payments = Receipt::searchLastPayment($idContract);
    $portions = Receipt::searchPortions($idContract);

    if (is_array($payments) && count($payments)) {
        $desPayment = end($payments);
        $desPayment = explode(" - ", $desPayment['desMonth']);
        $desPayment = end($desPayment);
        $desPayment = date('Y-m-d', strtotime(str_replace("/", "-", $desPayment)));
        $dtPayment = new DateTime($desPayment);
        $dtCurrent = new DateTime();

        if ($dtCurrent > $dtPayment) {
            $month = $dtCurrent->diff($dtPayment)->format("%m");
            $fined = ($contract[0]['desValue'] * $month) * 0.02;
        } else {
            $fined = null;
        }
    } else {
        $newDate = date("Y-m-d");
        $diff = strtotime($contract[0]['dtInitial']) - strtotime($newDate);
        $month = abs(floor($diff /(60*60*24*30)))-1;

        if ($month > 0) {
            $fined = ($contract[0]['desValue'] * $month) * 0.02;
        } else {
            $fined = null;
        }
    }

    $dayMaturity = date('d', strtotime($contract[0]['dtInitial']));
    $dayCurrent = date("d");
    $diff = $dayCurrent - $dayMaturity;

    if ($diff > 0) {
        $interest = $diff * 0.00033;
        $interest = round($contract[0]['desValue'] * $interest, 2);
    } else {
        $interest = null;
    }

    if (empty($payments)) {
        $valueDay = $contract[0]['desValue'] / 30;
    } else {
        $valueDay = 0;
    }

    $dtContract = explode("-", $contract[0]['dtInitial']);
    $dtContract = end($dtContract) . "-" . date("m-Y");

    $array = array($portions, $fined, $interest, $contract[0]['desValue'], $valueDay, $dtContract);
    echo json_encode($array);
});