<?php
// === register autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

$dbServer = '127.0.0.1';
$dbUserName = 'root';
$dbPassword = '';
$dbName = 'productratingdb';

$sp = new ServiceProvider;
// register services
// ---APPLICATION
// -------COMMANDS
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\SignOutCommand::class);
$sp->register(\Application\RegisterCommand::class);
$sp->register(\Application\CreateProductCommand::class);
$sp->register(\Application\CreateRatingCommand::class);
$sp->register(\Application\UpdateRatingCommand::class);
$sp->register(\Application\UpdateProductCommand::class);
$sp->register(\Application\DeleteRatingCommand::class);
// -------Queries
$sp->register(\Application\SignedInUserQuery::class);
$sp->register(\Application\ProductsForFilterQuery::class);
$sp->register(\Application\RatingsForProductQuery::class);
$sp->register(\Application\ProductQuery::class);
$sp->register(\Application\RatingsForUserQuery::class);
$sp->register(\Application\ProductsForUserAndFilterQuery::class);
$sp->register(\Application\RatingForUserAndProductQuery::class);

// ---Helper classes
$sp->register(\Application\Services\AuthenticationService::class);
$sp->register(\Application\Services\RatingsService::class);
$sp->register(\Application\Services\UserService::class);


// ---INFRASTRUCTURE
$sp->register(\Infrastructure\Repository::class, function () use ($dbServer, $dbUserName, $dbPassword, $dbName) {
    return new \Infrastructure\Repository($dbServer, $dbUserName, $dbPassword, $dbName);
}, isSingleton: true);
$sp->register(\Infrastructure\FakeRepository::class);
$sp->register(\Application\Interfaces\RatingRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\ProductRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);
$sp->register(\Infrastructure\Session::class, isSingleton: true);


// ---PRESENTATION
$sp->register(\Presentation\MVC\MVC::class, function () {
    return new \Presentation\MVC\MVC();
});
$sp->register(\Presentation\Controllers\Home::class);
$sp->register(\Presentation\Controllers\User::class);
$sp->register(\Presentation\Controllers\Products::class);
$sp->register(\Presentation\Controllers\Details::class);
$sp->register(\Presentation\Controllers\Ratings::class);


$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);