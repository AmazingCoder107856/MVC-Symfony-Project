Scrutinizer badges:

<a href="https://scrutinizer-ci.com/g/AmazingCoder107856/MVC-Symfony-Project/?branch=main"><img src="https://scrutinizer-ci.com/g/AmazingCoder107856/MVC-Symfony-Project/badges/quality-score.png?b=main" alt="Code Quality"></a>

<a href="https://scrutinizer-ci.com/g/AmazingCoder107856/MVC-Symfony-Project/?branch=main"><img src="https://scrutinizer-ci.com/g/AmazingCoder107856/MVC-Symfony-Project/badges/coverage.png?b=main" alt="Code Coverage"></a>

<a href="https://scrutinizer-ci.com/g/AmazingCoder107856/MVC-Symfony-Project/?branch=main"><img src="https://scrutinizer-ci.com/g/AmazingCoder107856/MVC-Symfony-Project/badges/build.png?b=main" alt="Build Status"></a>

<a href="https://scrutinizer-ci.com/g/AmazingCoder107856/MVC-Symfony-Project/?branch=main"><img src="https://scrutinizer-ci.com/g/AmazingCoder107856/MVC-Symfony-Project/badges/code-intelligence.svg?b=main" alt="Code Intelligence"></a>

Course repo for the mvc course.

Course is available at:

https://dbwebb.se/mvc
GitHub Pages for this repo are published at:

https://dbwebb-se.github.io/mvc
Clone the course repo (this repo).

Get going with Symfony. Install Symfony via https://github.com/dbwebb-se/mvc/tree/main/example/symfony. Developing an app för a specific card game using Symfony/PHP.

Get going with phpunit
This is short tutorial with code samples on how to get going with phpunit for unit testing and code coverage.

MVC objectoriented php course final project

I created a Poker game, where the user has to log in to be able to play.

The user play against the computer(dealer) and the one with the best hand winns the total pot of "money".

To set this game in to action I worked with MVC (models, views and controllers), through the Symfony and twig framwork, with the PHP language.

I've used the symfonys log in system make:user and make:auth. Ive been working with sessions to hold the game through every get and post request. And to store the users data I've worked with doctrine and ORM.

There is also phpunit test on all my own created classes, along with other automatized tests such as metrics and scrutinizer.

MVC objectoriented php course final project

I created a Poker game, where the user has to log in to be able to play.

The user play against the computer(dealer) and the one with the best hand winns the total pot of "money".

To set this game in to action I worked with MVC (models, views and controllers), through the Symfony and twig framwork, with the PHP language.

I've used the symfonys log in system make:user and make:auth. Ive been working with sessions to hold the game through every get and post request. And to store the users data I've worked with doctrine and ORM.

There is also phpunit test on all my own created classes, along with other automatized tests such as metrics and scrutinizer.

För att bygga appen på din enhet kan du följa dessa steg.

<a href="git clone git@github.com:AmazingCoder107856/MVC-Symfony-Project.git"></a>
cd MVC-Symfony-Project/
composer install
php bin/console doctrine:migration:migrate
npm install
npm run build

