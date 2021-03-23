<?php
require_once './config.php';
/* connexion a la base */
$pdo = new PDO('mysql:dbname=' . $_base . ';host=' . $_host, $_dbUser, $_dbMdp);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
