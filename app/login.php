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
<section class="hero">
  <!-- si erreurs -->
  <div class="hero-body">
    <div class="container has-text-centered">
      <div class="column is-4 is-offset-4">
        <h3 class="title has-text-black">Connexion</h3>
        <hr class="login-hr">
        <p class="subtitle has-text-black">Merci de remplir le formulaire</p>
        <div class="box">
          <figure class="avatar"><img src="https://picsum.photos/128/128?random" alt="Image random"></figure>
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
          <form method="post">
            <div class="field">
              <label class="label">Pseudo ou email</label>
              <input class="input" type="text" name="username" required placeholder="Nom utilisateur">
            </div>

            <div class="field">
              <input class="input" type="password" name="password" required placeholder="Votre mot de passe">
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
                <button class="button is-text" type="reset">Annuler</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <label class="label">Mot de passe <a href="forget.php">(Mot de passe oublié)</a></label>
    </div>
  </div>
</section>
<?php require_once '../_footer.php'; ?>