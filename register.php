<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once'inc/function.php';
//Si variable non vide
if (!empty($_POST)) {
    $errors = array();
    // ouverture de la base de données
    require_once'inc/db.php';
    // vérification pseudo
    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
        $errors['username'] = "Vous pseudo n'est pas valide!";
    } else {
        /* verifie si utilisateur est déjà existant */
        // prepare la requete
        $req = $pdo->prepare('SELECT id FROM users WHERE username=?');
        //execute la requete
        $req->execute([$_POST['username']]);
        // résultat
        $user= $req->fetch();
        // si déja utilisateur
        if ($user) {
            $errors['username'] = 'Ce pseudo est déjà pris!';
        }
    }
    // vérification email
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] ='Votre email n\'est pas valide!';
    } else {
        /* verifie si email est déjà existant */
        // prepare la requete
        $req = $pdo->prepare('SELECT id FROM users WHERE email=?');
        //execute la requete
        $req->execute([$_POST['email']]);
        // résultat
        $user= $req->fetch();
        // si déja email
        if ($user) {
            $errors['email'] = 'Cet email est déjà utilisé pour un autre compte!';
        }
    }
    //vérification password
    if (empty($_POST['password']) || $_POST["password"] != $_POST['confirm_password']) {
        $errors['password']= 'Vous devez entrer un mot de passe valide!';
    }
    /* envoi dans la base de données */
    //prepare la requete
    if (empty($errors)) {
        $req = $pdo->prepare("INSERT INTO users SET username = ? , password = ?, email = ?,confirmation_token = ?");
        // cryptage du mot de passe
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        // création du token
        $token = str_random(60);
        // envoi la requete
        $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
        // le dernier utilisateur
        $user_id = $pdo->LastInsertId();
        // envoi de l'email
        mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/www/login_base/confirm.php?id=$user_id&token=$token");
        $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte!';
        header('Location: login.php');
        exit();
    }
}
$titre_page = 'S\'incrire';
include_once'inc/header.php';
?>

<h1 class="title">S'incrire</h1>
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
    <div class="tab-content">
      <form  action="" method="post">
        <div class="field">
          <label class="label">Pseudo<span class="req">*</span>
          </label>
          <input class ="input" type="text" name="username" placeholder="Votre pseudo" required>
        </div>
        <div class="field">
          <label class="label">Email<span class="req">*</span>
          </label>
          <input class="input" type="email" name="email" placeholder="Votre adresse email" required>
        </div>
        <div class="FILTER_VALIDATE_EMAIL">
          <label class="label">Mot de passe<span class="req">*</span></label>
          <input class ="input" type="password" name="password" placeholder="Votre mot de passe" required>
        </div>
        <div class="field">
          <label class="label">Confirmer votre mot de passe<span class="req">*</span></label>
          <input class ="input" type="password" name="confirm_password" placeholder="Confirmer votre mot de passe">
        </div>
        <div class="field is-grouped">
          <div class="control">
            <button class="button is-link">S'incrire</button>
          </div>
          <div class="control">
            <input class="button" type="reset"value="Annuler">
          </div>
        </div>
      </form>
    </div>

<?php include_once'inc/footer.php'; ?>
