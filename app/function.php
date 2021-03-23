<?php

/* debugage des variables*/
function debug($variables)
{
    echo '<pre>' . print_r($variables, true) . '</pre>';
}
/* Token aléatoire */
function str_random($length)
{
    $string = "";
    $chaine = "01&()23456789*azert/yuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    srand((float)microtime() * 1000000);
    for ($i = 0; $i < $length; $i++) {
        $string .= $chaine[rand() % strlen($chaine)];
    }
    return $string;
}
// function  seulement si connecté
function logged_only()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['auth'])) {
        $_SESSION['flash']['danger'] = 'Vous n\'avez pas le droit d\'accèder à cette page!';
        header('Location: login.php');
        exit();
    }
}
// fonction de reconnection si cookie ok
function reconnect_from_cookie()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
        require_once './db.php';
        if (!isset($pdo)) {
            global $pdo;
        }
        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $user_id = $parts[0];
        $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute([$user_id]);
        $user = $req->fetch();
        if ($user) {
            $expected = $user->id . '//' . $user->$remember_token . sha1($user_id . 'clefdecryptage');
            if ($expected == $remember_token) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_session['auth'] = $user;
                setcookie('remember', $remember_token, time() + 86400 * 7);
            } else {
                setcookie('remember', null, -1);
            }
        } else {
            setcookie('remember', null, -1);
        }
    }
}
