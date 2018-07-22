<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\AdminMiddleware;
use App\Controllers\HomeController;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function() {
    $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', 'AuthController:postSignUp');
    
    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');
})->add(new GuestMiddleware($container));


$app->group('', function () {
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');

    $this->get('/main', 'HomeController:index')->setName('home');
})->add(new AuthMiddleware($container));

$app->get('/admin', 'AuthController:getAdminSignIn')->setName('admin.signin');
$app->post('/admin', 'AuthController:postAdminSignIn');

$app->group('', function() {
    $this->get('/admin/dash', 'AuthController:getAdminDashboard')->setName('admin.dash');
})->add(new AdminMiddleware($container));
?>