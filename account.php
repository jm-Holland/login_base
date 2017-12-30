<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require'inc/function.php';
//message si pas connecté
logged_only();
if (!empty($_POST)) {
    if (empty($_POST['password']) || $_POST['password'] != $_POST['confirm_password']) {
        $_SESSION['flash']['danger'] = 'Les mots de passes ne correspondent pas!';
    } else {
        $user_id = $_SESSION['auth']->id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once'inc/db.php';
        $pdo->prepare('UPDATE users SET password = ?')->execute([$password]);
        $_SESSION['flash']['success'] = 'Votre mot de passe a bien été mis à jour';
    }
}
$titre_page = 'account';
// mise en place du header
include_once'inc/header.php';?>
<section class="section">
  <h1 class="title">Bonjour <?= $_SESSION['auth']->username; ?></h1>
  <div class="tab_content">
    <form  action="" method="post">
      <div class="field">
        <input type="password" class="input" name="password" placeholder="Changer votre mot de passe"/>
      </div>
      <div class="field">
        <input type="password" class="input" name="confirm_password" placeholder="Confirmation du mot de passe"/>
      </div>
      <div class="field is-grouped">
      <div class="control">
        <button class="button is-link">Changer de mot de passe</button>
      </div>
    </form>
  </div>
</section>
<?php include_once'inc/footer.php'; ?>
