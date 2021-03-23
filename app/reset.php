<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (isset($_GET['id']) && isset($_GET['token'])) {
  require_once './db.php';
  require_once './function.php';
  $req = $pdo->prepare('SELECT * FROM users WHERE id= ? AND reset_token IS NOT NULL AND token= ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
  $req->execute([$_GET['id'], $_GET['token']]);
  $user = $req->fetch();
  if ($user) {
    if (!empty($_POST)) {
      if (!empty($_POST['password']) && $_POST['password'] == $_POST['confirm_password']) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute(['$password']);
        $_SESSION['flash']['success'] = 'Votre mot de passe a bien été modifié';
        $_SESSION['auth'] = $user;
        header('Location: account.php');
        exit();
      }
    }
  } else {
    $_SESSION['flash']['danger'] = 'Ce token n\'est pas valide!';
    header('Location: login.php');
    exit();
  }
} else {
  header('Location: login.php');
  exit();
}
?>

<?php require_once '../_header.php'; ?>


<h1 class="title">Modifier mon mot de passe</h1>
<!-- si erreurs -->
<?php if (!empty($errors)) : ?>
  <div class="notification is-danger">
    <h2>Attention!</h2>
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
    <label class="label">Nouveau mot de passe</label>
    <input class="input" type="password" name="password" required placeholder="Nouveau mot de passe">
  </div>
  <div class="field">
    <label class="label">Confirmer mot de passe</label>
    <input class="input" type="password" name="confirm_password" required placeholder="Confirmer mot de passe">
  </div>
  <div class="field is-grouped">
    <div class="control">
      <button class="button is-link">Réinitialiser le mot de passe</button>
    </div>
</form>

<?php require_once '../_footer.php'; ?>