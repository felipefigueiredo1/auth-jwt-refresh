<?php
require '../vendor/autoload.php';
require '../conf/bootstrap.php';

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TextController;

$request = $_SERVER['REQUEST_URI'];
$method  = $_SERVER['REQUEST_METHOD'];

switch ($request) {
    case '/login':
        if($method == 'POST') {
            call_user_func([new AuthController(), 'login']);
            
            break;
        } else {
            http_response_code(404);
            require __DIR__ . '../404.html';
            break;
        }

    case '/auth':
        call_user_func([new AuthController(), 'auth']);
            
        break;

    case '/refresh':
        call_user_func([new AuthController(), 'refreshToken']);
            
        break;
    
    case '/resource':
        call_user_func([new TextController(), 'resource']);
            
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}


