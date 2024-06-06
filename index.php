<?php
// === register autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

$sp = new ServiceProvider;
// register services
// ---APPLICATION
// -------COMMANDS
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\SignOutCommand::class);
// -------Queries
$sp->register(\Application\SignedInUserQuery::class);

// ---Helper classes
$sp->register(\Application\Services\AuthenticationService::class);


// ---INFRASTRUCTURE
$sp->register(\Infrastructure\FakeRepository::class);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\FakeRepository::class);
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);
$sp->register(\Infrastructure\Session::class, isSingleton: true);

// ---PRESENTATION
$sp->register(\Presentation\MVC\MVC::class, function(){
    return new \Presentation\MVC\MVC();
});
$sp->register(\Presentation\Controllers\Home::class);
$sp->register(\Presentation\Controllers\User::class);


$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);