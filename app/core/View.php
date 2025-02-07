<?php

namespace App\core;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
require realpath(__DIR__."/../../vendor/autoload.php");

class View {
    public static function render($view, $data = []) {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $twig = new Environment($loader, [
            'cache' => __DIR__ . '/../cache',
            'auto_reload' => true // Refreshes templates automatically
        ]);
        echo $twig->render("$view.twig", $data);
    }
}