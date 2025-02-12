<?php
namespace App\core;

use App\controllers\HomeController;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Router {
    protected $routes = [];
    private Environment $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $this->twig = new Environment($loader, [
            'cache' =>  "",
            'debug' => true
        ]);
    }

    private function addRoute($route, $controller, $action, $method)
    {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "GET");
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "POST");
    }
    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)}/', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches);
                $controller = $handler['controller'];
                $action = $handler['action'];

                $controller = new $controller();
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }

        header("Location:/");
    }
}
