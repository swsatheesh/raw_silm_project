<?php

    use Respect\Validation\Validator as v;

    session_start();

    require '../vendor/autoload.php';

    $app = new \Slim\App([
        'settings' => [
            'displayErrorDetails' => true,
            'db' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'rawsilmproject',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => ''
            ]
        ]
        
    ]);

    $container = $app->getContainer();


    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    $container['db'] = function($container) use ($capsule) {
        return $capsule;
    };

    $container['validator'] = function ($container) {
        return new StockAnalysis\Validation\Validator;
    };

    $container['AuthController'] = function ($container) {
        return new \StockAnalysis\Controllers\Auth\AuthController($container);
    };

    $container['PasswordController'] = function ($container) {
        return new \StockAnalysis\Controllers\Auth\PasswordController($container);
    };

    $container['UserController'] = function ($container) {
        return new \StockAnalysis\Controllers\User\UserController($container);
    };

    $app->add(new \StockAnalysis\Middleware\ValidationErrorsMiddleware($container));

    $container['auth'] = function() {
        return new \StockAnalysis\Auth\Auth;
    };

    // $container['csrf'] = function() {
    //     return new \Slim\Csrf\Guard;
    // };

    // $app->add($container->csrf);

    v::with('StockAnalysis\\Validation\\Rules');

    require '../app/routes.php';