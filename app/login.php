<?php
require_once 'function.php';
reconnect_from_cookie();

if (isset($_SESSION['auth'])) {
  header('Location:account.php');
}
require_once 'db.php';
if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
  $req = $pdo->prepare('SELECT * FROM users WHERE username = :username OR email = :username AND confirmed_at IS NOT NULL');
  $req->execute(['username' => $_POST['username']]);
  $user = $req->fetch();


  if (password_verify($_POST['password'], $user->password)) {
    $_SESSION['auth'] = $user;
    $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
    if ($_POST['remember']) {
      $remember_token = str_random(250);
      $pdo->prepare('UPDATE users SET remember_token = ? WHERE id= ?')->execute([$remember_token, $user->id]);
      setcookie('remember', $user->id . '//' . $remember_token . sha1($user->id . 'clefdecryptage'), time() + 86400 * 7);
    }
    header('Location: account.php');
    exit();
  } else {
    $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte !';
  }
}
?>
<?php require_once '../_header.php'; ?>
<!--  Debut du HTML -->
<h1 class=title>Se connecter</h1>
<!-- si erreurs -->
<?php if (!empty($errors)) : ?>
  <div class="notification is-danger">
    <h2 class="title">Attention!</h2>
    <p>Veuillez corriger les erreurs suivantes : </p>
    <ul>
      <!-- boucles sur chaques erreurs -->
      <?php foreach ($errors as $error) : ?>
        <li><?= $error; ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif ?>
<form action="" method="post">
  <div class="field">
    <label class="label">Pseudo ou email</label>
    <input class="input" type="text" name="username" required placeholder="Nom utilisateur">
  </div>

  <div class="field">
    <label class="label">Mot de passe <a href="forget.php">(Mot de passe oublié)</a></label>
    <input class="inputl" type="password" name="password" required placeholder="Votre mot de passe">
  </div>
  <div class="field">
    <div class="control">
      <label class="checkbox">
        <input type="checkbox">
        Se souvenir de moi
      </label>
    </div>
  </div>
  <div class="field is-grouped">
    <div class="control">
      <button class="button is-link">Se connecter</button>
    </div>
    <div class="control">
      <button class="button is-text">Annuler</button>
    </div>
  </div>
  <?php require_once '../_footer.php'; ?>