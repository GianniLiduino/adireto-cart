<?php

namespace App\Http\Middlewares;

class isAuth
{
    function __construct()
    {
        $this->checkIfUserIsAuth();
    }

    private function checkIfUserIsAuth()
    {
        if (!$_SESSION['user']) {
            header('Location: /login');
            die();
        }
    }
}
