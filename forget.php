<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  require_once'inc/db.php';
require_once'inc/function.php';
if (!empty($_POST) && !empty($_POST['email'])) {
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if ($user) {
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id ]);

        $_SESSION['flash']['success'] = 'Les instructions du rappel du mot de passe vous ont été envoyés par email';
        mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttp://localhost/www/login_base/reset.php?id={$user->id}&token=$reset_token");

        header('Location: login.php');
        exit();
    } else {
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cette adresse !';
    }
}
?>
<?php require_once'inc/header.php'; ?>
<!-- Début du Html -->
<h1 class="title">Se connecter</h1>
<!-- si erreurs -->
<?php if (!empty($errors)): ?>
  <div class="notification is-danger">
    <h2 class="title">Attention!</h2>
    <p>Veuillez corriger les erreurs suivantes : </p>
    <ul>
      <!-- boucles sur chaques erreurs -->
    <?php foreach ($errors as $error): ?>
      <li><?= $error; ?></li>
    <?php endforeach; ?>
  </ul>
  </div>
    <?php endif ?>
    <!-- Mise en place du formulaire HTML -->
<form  action="" method="post">
  <div class="field">
    <label class="label"> email</label>
    <input class ="input" type="email" name="email" required placeholder="Nom utilisateur">
  </div>
  <div class="field is-grouped">
    <div class="control">
      <button class="button is-link">Se connecter</button>
    </div>
</form>

<?php require_once'inc/footer.php'; ?>
