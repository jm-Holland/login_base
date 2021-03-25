# APP login_base

Espace login pour site web en PHP

Acces login pour un site en php

## Installation

Commencez par créer une base de données Mysql,

ensuite insérer la table User avec la commande sql suivante:

```bash
CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

### Paramêtre du fichier config.php

Ouivrir le fichier config.php et saisir les informations demandés concernant la connexion à la base de donnée.

### A vous de jouer

Beaucoup d'amélioration peuvent-être apportés.Ce n'est qu'une base de départ.
