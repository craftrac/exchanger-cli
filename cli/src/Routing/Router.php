<?php
namespace Exchanger\Routing;

use AltoRouter;


class Router
{
    protected $match;
    protected $controller;
    protected $method;

    public function __construct(AltoRouter $router)
    {
        $this->match = $router->match();

        if ($this->match) {
            // $this->match = self::sessionCheck($this->match);
            $this->match = self::protectCron($this->match);
            list($controller, $method) = explode('@', $this->match['target']);
            $this->controller = $controller;
            $this->method = $method;
            if (is_callable([new $this->controller(), $this->method])) {
                call_user_func_array(
                    [new $this->controller(), $this->method],
                    [$this->match['params']]
                );
            } else {
                echo "The method {$this->method} is not defined in {$this->controller}";
            }
        } else {
            header($_SERVER['SERVER_PROTOCOL'].'404 Not Found');
            /* view('errors/404'); */
            echo "404: Page not found";
        }
    }

    protected static function sessionCheck($route) {
        if (!isset($_SESSION['user_id']) && !($route['name'] === 'login' || $route['name'] === 'usersignin' || $route['name'] === 'guestsignin')) {
            if (!isset($_SESSION['user_id']) && !($route['name'] === 'login' || $route['name'] === 'usersignin' || $route['name'] === 'guestsignin')) {
                $route['target'] = "MSFD\Controllers\AuthController@index";
    
                return $route;
            }
    
            return $route;
        }
    }


    protected static function protectCron($route) {
        if ($route['name'] === 'check' || $route['name'] === 'vpos' || $route['name'] === 'npos') {
            // allow access only from localhost for cron services
            if(isset($_SERVER['REMOTE_ADDR']) AND ( $_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR'] )) {
                http_response_code(403);
                die(' Access Denied, Your IP: ' . $_SERVER['REMOTE_ADDR'] );
            } else {
                return $route;
            }
        } else {
            return $route;
        }
    }

}

