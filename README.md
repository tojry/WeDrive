# WeDrive

## Guide d’installation et d’utilisation de l’application

### Version Ubuntu (en local)

#### Prérequis : 
* PHP 8.1 ou supérieur et ces extensions PHP (qui sont installées et activées par défaut dans la plupart des installations PHP 8) : Ctype, iconv, PCRE, Session, SimpleXML et Tokenizer  
* Composer  
* Symfony CLI

#### Pour installer la base de données :

* Installer un gestionnaire de base de donnée (mariadb / MySQL) : 
`sudo apt install mariadb-client-core-10.3`
* Ajouter un utilisateur:
`sudo mysql -root`
* Exécuter les lignes suivantes une par une en remplaçant new user et password par des identifiants de votre choix :  

`CREATE USER 'new_user'@'localhost' IDENTIFIED BY 'password';`  
`GRANT ALL PRIVILEGES ON * . * TO 'new_user'@'localhost';`  
`FLUSH PRIVILEGES;`  
`exit` pour quitter .
* Créer un fichier .env.local dans le dossier WeDrive et écrire dedans :  

`DATABASE_URL="mysql://user:password@127.0.0.1:3306/weDrive?serverVersion=mariadb-10.5.8"`  

en modifiant “user” et “password” avec les identifiant que vous avez choisie. 
* On crée la base de données :
`php bin/console doctrine:database:create`
* On crée les tables :  
`php bin/console make:migration`                                                    
`php bin/console doctrine:migrations:migrate`

#### Pour phpMyAdmin :

* Il faut l’installer : `sudo apt install phpmyadmin`
* Se diriger vers : http://localhost/phpmyadmin/
* Si la BDD WeDrive n’est pas visible, taper dans le terminal les commandes suivantes :  
`sudo mysql -u root`                              
`GRANT ALL PRIVILEGES ON weDrive.* TO 'phpmyadmin'@'localhost';`                                                      
`FLUSH PRIVILEGES;`  
`exit`  
	
* Il ne reste qu’à lancer le serveur local avec : `symfony server:start` et vous diriger vers http://localhost:8000/ sur votre navigateur.

### Déploiement

* Suivre à la lettre la documentation de Symfony à l’adresse suivante  : https://symfony.com/doc/current/deployment.html
