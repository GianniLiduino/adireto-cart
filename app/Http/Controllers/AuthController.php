<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;

class AuthController
{
    private $userModel;
    private $cartModel;

    function __construct()
    {
        $this->userModel = new User();
        $this->cartModel = new Cart();
    }

    public function showLoginForm()
    {
        require dirname(__FILE__, 4) . '/pages/login.php';
    }

    public function login()
    {
        $errors = array();

        $data = array();

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $data['email'] = $email;

        if ($email) {
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if ($email === false) {
                $errors['Email'] = EMAIL_INVALID;
            }
        } else {
            $errors['Email'] = EMAIL_REQUIRED;
        }

        $user = $this->userModel->findByEmail($data['email']);

        $password = $_POST['password'] ?? null;
        $data['password'] = $password;
        if ($password) {
            if (!password_verify($password, $user->getPassword())) {
                $errors['Senha'] = PASSWORD_INVALID;
            }
        } else {
            $errors['Senha'] = PASSWORD_REQUIRED;
        }

        if (!$user) {
            return redirect('/login', ['errors' => ['Usuário' => 'Usuário não encontrado.']]);
        }

        if (count($errors) > 0) {
            return redirect('/login', ['errors' => $errors]);
        }

        $this->cartModel->initCartSession();

        $_SESSION["user"] = [
            'id' => $user->getId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail()
        ];

        return redirect('/');
    }

    public function showRegisterForm()
    {
        require dirname(__FILE__, 4) . '/pages/register.php';
    }

    public function register()
    {
        $errors = array();

        $data = array();

        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_DEFAULT);
        $data['first_name'] = $first_name;
        if ($first_name) {
            $pattern = '/^[a-zA-Z\s]+$/';
            $first_name = preg_match($pattern, $first_name) ? $first_name : false;
            if ($first_name === false) {
                $errors['Nome'] = FIRST_NAME_INVALID;
            }
        } else {
            $errors['Nome'] = FIRST_NAME_REQUIRED;
        }

        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_DEFAULT);
        $data['last_name'] = $last_name;
        if ($last_name) {
            $pattern = '/^[a-zA-Z\s]+$/';
            $last_name = preg_match($pattern, $last_name) ? $last_name : false;
            if ($last_name === false) {
                $errors['Sobrenome'] = LAST_NAME_INVALID;
            }
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $data['email'] = $email;

        if ($email) {
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if ($email === false) {
                $errors['Email'] = EMAIL_INVALID;
            }
        } else {
            $errors['Email'] = EMAIL_REQUIRED;
        }

        $password = $_POST['password'] ?? null;
        $data['password'] = $password;
        if ($password) {
            $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/';
            $password = preg_match($pattern, $password) ? $password : false;
            if ($password === false) {
                $errors['Senha'] = PASSWORD_INVALID;
            }
        } else {
            $errors['Senha'] = PASSWORD_REQUIRED;
        }

        $confirm_password = $_POST['confirm_password'] ?? null;
        $data['confirm_password'] = $confirm_password;
        if ($confirm_password) {
            if ($confirm_password !== $password) {
                $errors['Confirmar senha'] = CONFIRM_PASSWORD_MISMATCH;
            }
        } else {
            $errors['Confirmar senha'] = CONFIRM_PASSWORD_REQUIRED;
        }

        if (count($errors) > 0) {
            return redirect('/register', ['errors' => $errors]);
        }

        $user = $this->userModel->findByEmail($data['email']);

        if ($user) {
            return redirect('/register', ['errors' => ['Email' => 'O email já está em uso!']]);
        }

        $this->userModel->create($data);

        return redirect('/login');
    }

    public function logout()
    {
        session_destroy();
        return redirect('/');
    }

    public function resetPassword()
    {
    }
}
