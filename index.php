<?php

session_start();
use App\database\Database;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function debug( $arg ){

    echo "<div style='background:#fda500; z-index:1000; padding:15px;'>";

        $trace = debug_backtrace();
        //debug_backtrace() : fonction interne de PHP qui retourne un array avec des infos à l'endroit où l'on fait appel à la fonction.

        echo "<p>Debug demandé dans le fichier : ". $trace[0]['file'] ." à la ligne ". $trace[0]['line'] ."</p>";

        echo "<pre>";
            print_r( $arg );
        echo "</pre>";

    echo "</div>";
}

require 'vendor/autoload.php';

class Application
{
    const AUTHORIZED_PAGES = [
        'index' => [
            'controller' => 'QuestionController',
            'method' => 'index'
        ],
        'question' => [
            'controller' => 'QuestionController',
            'method' => 'showQuestion'
        ],
        'answer' => [
            'controller' => 'AnswerController',
            'method' => 'create'
        ],
        'ask' => [
            'controller' => 'QuestionController',
            'method' => 'create'
        ],
        'login' => [
            'controller' => 'UserController',
            'method' => 'login'
        ],
        'logout' => [
            'controller' => 'UserController',
            'method' => 'logout'
        ],
        'error404' => [
            'controller' => 'ErrorController',
            'method' => 'error404'
        ],
    ];

    const DEFAULT_ROUTE = 'index';

    private function match($route_name)
    {
        // je vérifie sir la clef existe dans la liste des pages autorisées
        if (isset(self::AUTHORIZED_PAGES[$route_name])) {
            $route = self::AUTHORIZED_PAGES[$route_name];
        } else {
            $route = self::AUTHORIZED_PAGES['error404'];
        }

        return $route;
    }

    public function run()
    {
        // je récupère la route demandée dans l'url
        // si la page n'est pas spécifiée (ex: on arrive pour la première fois sur le site)
        // on redirige vers la page d'accueil
        $route_name = $_GET['page'] ?? self::DEFAULT_ROUTE;

        // je vérifie si la route demandée existe
        $route = $this->match($route_name);

        // j'instancie le controller correspondant à la route demandée
        $controller_name = 'App\Controller\\' . $route['controller'];
        $controller = new $controller_name();

        // j'appelle la méthode correspondante à la route demandée
        $method_name = $route['method'];
        $controller->$method_name();

    }
}

$application = new Application();
$application->run();