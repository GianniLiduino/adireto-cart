<?php

function redirect($url, $errors = [])
{
    if (!isset($url)) {
        var_dump("Url não definida");
    }
    if (count($errors) > 0) {
        foreach ($errors as $index => $value) $_SESSION[$index] = $value;
    }
    header("Location: $url");
    die();
}

function checkError($error)
{
    if (isset($_SESSION[$error])) {
        echo $_SESSION[$error];
        unset($_SESSION[$error]);
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function url($path)
{
    echo 'http://' . $_SERVER['HTTP_HOST'] . $path;
    return;
}