<?php

namespace ALImoveis\Models;

use ALImoveis\Dao\Dao;
use ALImoveis\Model;

class Login extends Model
{
    const SESSION = "User";

    // Realiza o login no Sistema
    public static function login($login, $password)
    {
        $sql = new Dao();
        $results = $sql->allSelect("SELECT * FROM tbuser WHERE desUser = :LOGIN", array(
            ':LOGIN' => $login
        ));

        if (count($results) === 0) {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Usuário ou senha incorreto.");
            header("Location: /login");
            exit;
        }

        $data = $results[0];

        if (password_verify($password, $data['desPassword']) === true) {
            $user = new Login();
            $user->setData($data);
            session_regenerate_id(true);
            $_SESSION[Login::SESSION] = $user->getValues();
            return $user;
        } else {
            $_SESSION['error'] = array(
                'type' => "danger",
                'ico' => "fa-ban",
                'title' => "Erro",
                'msg' => "Usuário ou senha incorreto.");
            header("Location: /login");
            exit;
        }
    }

    // Realiza o logout no Sistema
    public static function logout()
    {
        unset($_SESSION[Login::SESSION]);
        //$_SESSION[Login::SESSION] = NULL;
    }

    // Verifica se o usuário ainda continua logado
    public static function verifyLogin()
    {
        if (
            !isset($_SESSION[Login::SESSION]) ||
            !$_SESSION[Login::SESSION] ||
            !(int) $_SESSION[Login::SESSION]['idUser'] > 0
        ) {
            if (isset($_SESSION[Login::SESSION])) {
                $_SESSION['error'] = array(
                    'type' => "warning",
                    'ico' => "fa-warning",
                    'title' => "Atenção",
                    'msg' => "Usuário não está mais logado.");
                header("Location: /login");
            } else {
                header("Location: /login");
            }
            exit;
        }
    }

    public function getUser($iduser)
    {
        $sql = new Dao();
        $result = $sql->allSelect("SELECT * FROM tbuser WHERE idUser = :IDUSER", array(
            ':IDUSER' => $iduser
        ));

        $this->setData($result[0]);
    }
}