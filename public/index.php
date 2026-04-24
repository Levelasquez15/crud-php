<?php
// public/index.php

(function (): void {
    $requestPath = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    $publicBase  = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    if ($publicBase === '/') {
        $publicBase = '';
    }
    
    if ($requestPath !== $publicBase && !str_starts_with($requestPath, $publicBase . '/')) {
        session_start();
        $dest = isset($_SESSION['auth']['id']) ? 'home' : 'auth.login';
        header('Location: ' . $publicBase . '/?route=' . $dest);
        exit;
    }
})();

require_once __DIR__ . '/../Common/ClassLoader.php';
ClassLoader::register();

DependencyInjection::boot();
Flash::start();

$route  = $_GET['route'] ?? 'home';
$routes = WebRoutes::getRoutes();

// CAMBIO 1 — se agregó 'auth.reset' y 'auth.reset.save'
$publicRoutes = ['home', 'auth.login', 'auth.authenticate', 'users.create', 'users.store', 'auth.logout', 'auth.forgot', 'auth.forgot.send', 'auth.reset', 'auth.reset.save', 'auth.verify'];
if (!in_array($route, $publicRoutes)) {
    if (!isset($_SESSION['auth']['id'])) {
        View::redirect('auth.login');
        exit;
    }
}

try {
    $routeConfig = $routes[$route] ?? null;
    if (!$routeConfig) {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== $routeConfig['method']) {
        header("HTTP/1.0 405 Method Not Allowed");
        echo "405 Method Not Allowed";
        exit;
    }

    $controllerName = $routeConfig['controller'];
    $action = $routeConfig['action'];
    $methodName = "get{$controllerName}";

    $controller = DependencyInjection::$methodName();

    switch ($route) {
        case 'home':
            $controller->index();
            View::render('home', [
                'pageTitle' => 'Inicio',
                'message'   => Flash::message(),
                'success'   => Flash::success(),
            ]);
            break;
            
        case 'users.index':
            $users = $controller->index();
            View::render('users/list', [
                'pageTitle' => 'Lista de Usuarios',
                'users'     => $users,
                'message'   => Flash::message(),
                'success'   => Flash::success(),
            ]);
            break;
            
        case 'users.create':
            $controller->create();
            View::render('users/create', [
                'pageTitle' => 'Crear Usuario',
                'message'   => Flash::message(),
                'success'   => Flash::success(),
                'errors'    => Flash::errors(),
                'old'       => Flash::old(),
                'roleOptions' => UserRoleEnum::values()
            ]);
            break;
            
        case 'users.store':
            $id = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
            
            $request = new CreateUserWebRequest(
                $id,
                $_POST['name'] ?? '',
                $_POST['email'] ?? '',
                $_POST['password'] ?? '',
                $_POST['role'] ?? ''
            );
            
            $controller->store($request);
            Flash::setSuccess('Usuario registrado correctamente.');
            View::redirect('users.index');
            break;
            
        case 'users.show':
            $id = $_GET['id'] ?? '';
            $user = $controller->show($id);
            View::render('users/show', [
                'pageTitle' => 'Detalle de Usuario',
                'user'      => $user,
                'message'   => Flash::message()
            ]);
            break;
            
        case 'users.edit':
            $id = $_GET['id'] ?? '';
            $user = $controller->edit($id);
            View::render('users/edit', [
                'pageTitle' => 'Editar Usuario',
                'user'      => $user,
                'message'   => Flash::message(),
                'errors'    => Flash::errors(),
                'old'       => Flash::old(),
                'roleOptions' => UserRoleEnum::values(),
                'statusOptions' => UserStatusEnum::values()
            ]);
            break;
            
        case 'users.update':
            $id = $_POST['id'] ?? '';
            $request = new UpdateUserWebRequest(
                $id,
                $_POST['name'] ?? '',
                $_POST['email'] ?? '',
                $_POST['password'] ?? '',
                $_POST['role'] ?? '',
                $_POST['status'] ?? ''
            );
            $controller->update($request);
            Flash::setSuccess('Usuario editado exitosamente.');
            View::redirect('users.index');
            break;
            
        case 'users.delete':
            $id = $_POST['id'] ?? '';
            $controller->delete($id);
            Flash::setSuccess('Usuario eliminado exitosamente.');
            View::redirect('users.index');
            break;

        case 'auth.login':
            $controller->showLogin();
            View::render('auth/login', [
                'pageTitle' => 'Login',
                'message'   => Flash::message(),
                'success'   => Flash::success(),
                'old'       => Flash::old()
            ]);
            break;

        case 'auth.authenticate':
            $request = new LoginWebRequest($_POST['email'] ?? '', $_POST['password'] ?? '');
            $userResponse = $controller->authenticate($request);
            
            $_SESSION['auth'] = [
                'id'    => $userResponse->getId(),
                'name'  => $userResponse->getName(),
                'email' => $userResponse->getEmail(),
                'role'  => $userResponse->getRole(),
            ];
            Flash::setSuccess('Bienvenido/a, ' . $userResponse->getName() . '.');
            View::redirect('home');
            break;

        case 'auth.logout':
            session_destroy();
            header('Location: ?route=auth.login');
            exit;

        case 'auth.forgot':
            $controller->showForgotPassword();
            View::render('auth/forgot-password', [
                'pageTitle' => 'Recuperar Contraseña',
                'message'   => Flash::message(),
                'success'   => Flash::success(),
                'old'       => Flash::old()
            ]);
            break;

        case 'auth.forgot.send':
            $email = trim($_POST['email'] ?? '');
            $controller->processForgotPassword($email);
            Flash::setSuccess('Si el correo existe en nuestra plataforma, hemos enviado un enlace de recuperación de contraseña.');
            View::redirect('auth.forgot');
            break;

        // CAMBIO 2 — casos nuevos de reset
        case 'auth.reset':
            $controller->showResetPassword();
            View::render('auth/reset-password', [
                'pageTitle' => 'Nueva Contraseña',
                'token'     => $_GET['token'] ?? '',
                'message'   => Flash::message(),
            ]);
            break;

        case 'auth.reset.save':
            $controller->processResetPassword(
                $_POST['token']    ?? '',
                $_POST['password'] ?? ''
            );
            Flash::setSuccess('Contraseña actualizada. Ya puedes iniciar sesión.');
            View::redirect('auth.login');
            break;

        case 'auth.verify':
            $userResponse = $controller->verifyEmail();
            $_SESSION['auth'] = [
                'id'    => $userResponse->getId(),
                'name'  => $userResponse->getName(),
                'email' => $userResponse->getEmail(),
                'role'  => $userResponse->getRole(),
            ];
            Flash::setSuccess('¡Correo electrónico verificado! Tu cuenta está activada.');
            View::redirect('home');
            break;
            
    }

} catch (Throwable $exception) {
    $msg = $exception->getMessage();
    Flash::setMessage($msg);

    switch ($route) {
        case 'users.store':
            Flash::setOld($_POST);
            View::redirect('users.create');
            break;
        case 'users.update':
            Flash::setOld($_POST);
            View::redirect('users.edit', ['id' => $_POST['id'] ?? '']);
            break;
        case 'auth.authenticate':
            Flash::setOld(['email' => $_POST['email'] ?? '']);
            View::redirect('auth.login');
            break;
        // CAMBIO 3 — manejo de error en reset
        case 'auth.reset.save':
            View::redirect('auth.reset', ['token' => $_POST['token'] ?? '']);
            break;
        case 'users.index':
            View::redirect('home');
            break;
        case 'home':
            die("Error en Inicio: " . htmlspecialchars($msg));
        default:
            View::redirect('home');
            break;
    }
}