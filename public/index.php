<?php

require_once __DIR__ . '/../src/core/Autoloader.php';
Src\Core\Autoloader::register();

use Src\Core\Router;
use Src\Controllers\HomeController;
use Src\Controllers\AuthController;
use Src\Controllers\ArticleController;
use Src\Controllers\CategoryController;
use Src\Controllers\CommentController;
use Src\Controllers\LikeController;

$router = new Router();

// Define routes
$router->get('/', [HomeController::class, 'index']);

// Auth
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Articles
$router->get('/articles', [ArticleController::class, 'index']);
$router->get('/articles/create', [ArticleController::class, 'create']);
$router->post('/articles', [ArticleController::class, 'store']);
// Dynamic route handling would require more robust router regex, but for now assuming query params for ID or specific paths
// Using query param ?id=1 for show

// Comments & Likes
$router->post('/comments', [CommentController::class, 'store']);
$router->post('/likes', [LikeController::class, 'toggle']);

$router->dispatch();
