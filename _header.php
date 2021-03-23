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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css">
  <!-- Custom styles for this template -->
  <link href="public/css/master.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a href="/index.php" class="navbar-item">
        <img src="https://picsum.photos/150/150" alt="Logo">
      </a>
      <div class="navbar-burger burger" data-target="toggle">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="navbar-menu navbar-end" id="toggle">
      <?php if (isset($_SESSION['auth'])) : ?>
        <a class="navbar-item" href="../app/logout.php">Se déconnecter</a>
      <?php else : ?>
        <a class="navbar-item" href="../app/register.php">S'incrire</a>
        <a class="navbar-item" href="../app/login.php">Se connecter</a>
      <?php endif; ?>
    </div>
  </nav>

  <section class="section">

    <?php if (isset($_SESSION['flash'])) : ?>
      <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
        <div class="notification is-<?= $type; ?>"><?= $message; ?>
        </div>
      <?php endforeach; ?>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
  </section>