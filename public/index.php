<?php

declare(strict_types=1);

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

require_once '../vendor/autoload.php';

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($userId === 'user' && $password === 'password') {
        $message = 'You are logged in';
        $isLogged = true;
    } else {
        $message = 'Invalid credentials';
        $isLogged = false;
    }
}

try {
    echo $twig->render('login.twig', ['message' => $message, 'isLogged' => $isLogged ?? false]);
} catch (LoaderError|SyntaxError|RuntimeError $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
