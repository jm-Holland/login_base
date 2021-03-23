<?php

namespace app;

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require './function.php';
//message si pas connecté
logged_only();
if (!empty($_POST)) {
  if (empty($_POST['password']) || $_POST['password'] != $_POST['confirm_password']) {
    $_SESSION['flash']['danger'] = 'Les mots de passes ne sont pas identiques!';
  } else {
    $user_id = $_SESSION['auth']->id;
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    require_once './db.php';
    $pdo->prepare('UPDATE users SET password = ?')->execute([$password]);
    $_SESSION['flash']['success'] = 'Votre mot de passe a bien été mis à jour';
  }
}
// mise en place du header
include_once '../_header.php'; ?>

<h1 class="title">Bonjour <?= $_SESSION['auth']->username; ?></h1>
<form action="" method="post">
  <div class="field">
    <input type="password" class="input" name="password" placeholder="Changer votre mot de passe" />
  </div>
  <div class="field">
    <input type="password" class="input" name="confirm_password" placeholder="Confirmation du mot de passe" />
  </div>
  <div class="field is-grouped">
    <div class="control">
      <button class="button is-link">Changer de mot depasse</button>
    </div>
</form>




<?php include_once '../_footer.php'; ?>