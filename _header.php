<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once 'app/function.php';
?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Mon super projet</title>
  <!-- Bulma core CSS -->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Custom styles for this template -->
  <link href="/public/css/master.css" rel="stylesheet">
</head>

<body>
  <section class="hero is-default is-bold">
    <div class="hero-head">
      <nav class="navbar">
        <div class="container">
          <div class="navbar-brand">
            <a class="navbar-item" href="../">
              <img src="/public/image/logo.png" alt="Logo">
            </a>
            <span class="navbar-burger burger" data-target="navbarMenu">
              <span></span>
              <span></span>
              <span></span>
            </span>
          </div>
          <div id="navbarMenu" class="navbar-menu">
            <div class="navbar-end">
              <div class="tabs is-right">
                <ul>
                  <li class="is-active"><a href="../">Home</a></li>
                  <li><a href="/app/register.php">S'incrire</a></li>
                  <li><a href="/app/login.php">Se connecter</a></li>
                  <li><a href="/app/logout.php">Se déconnecter</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>


    <?php if (isset($_SESSION['flash'])) : ?>
      <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
        <div class="notification is-<?= $type; ?>"><?= $message; ?>
        </div>
      <?php endforeach; ?>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
  </section>