# Twitter

Application permettant à l'utilisateur de poster des tweets, de suivre les tweets poster par d'autres utilisateurs et de gérer
ses abonnements.


## Requis:

Dans le but d'utiliser ce logiciel, vous aurez besoin de:
- Visual Studio Code
- MySQL Workbench
- Laravel 8.0 & Jetstream
- VueJS 2.9.6
- Inertia 0.3.5
- PHP 7.4

## Installation

Créer un schéma dans mySQL Workbench.
Remplir le .env avec le nom du schéma, et vos identifiants de connexion à la base de données.

Lancer:
`composer install` 
`npm install`
`php artisan key:generate`
`php artisan migrate`
`php artisan db:seed`

Lancer le serveur:
`php artisan serve`