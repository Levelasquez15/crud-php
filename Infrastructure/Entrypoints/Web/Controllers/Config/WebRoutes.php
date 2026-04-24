<?php
// Infrastructure/Entrypoints/Web/Controllers/Config/WebRoutes.php

class WebRoutes {
    public static function getRoutes(): array {
        return [
            'home'              => ['method' => 'GET',  'controller' => 'HomeController', 'action' => 'index'],
            
            'users.index'       => ['method' => 'GET',  'controller' => 'UserController', 'action' => 'index'],
            'users.create'      => ['method' => 'GET',  'controller' => 'UserController', 'action' => 'create'],
            'users.store'       => ['method' => 'POST', 'controller' => 'UserController', 'action' => 'store'],
            'users.show'        => ['method' => 'GET',  'controller' => 'UserController', 'action' => 'show'],
            'users.edit'        => ['method' => 'GET',  'controller' => 'UserController', 'action' => 'edit'],
            'users.update'      => ['method' => 'POST', 'controller' => 'UserController', 'action' => 'update'],
            'users.delete'      => ['method' => 'POST', 'controller' => 'UserController', 'action' => 'delete'],
            
            'auth.login'        => ['method' => 'GET',  'controller' => 'AuthController', 'action' => 'showLogin'],
            'auth.authenticate' => ['method' => 'POST', 'controller' => 'AuthController', 'action' => 'authenticate'],
            'auth.logout'       => ['method' => 'GET',  'controller' => 'AuthController', 'action' => 'logout'],
            
            'auth.forgot'       => ['method' => 'GET',  'controller' => 'AuthController', 'action' => 'showForgotPassword'],
            'auth.forgot.send'  => ['method' => 'POST', 'controller' => 'AuthController', 'action' => 'processForgotPassword'],
            
            'auth.verify'       => ['method' => 'GET',  'controller' => 'AuthController', 'action' => 'verifyEmail'],
        ];
    }
}
