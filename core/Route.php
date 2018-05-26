<?php

namespace Core;

class Route
{
    private $routes;

    public function __construct(array $routes)
    {
        $this->setRoutes($routes);
        $this->run();
    }

    private function setRoutes($routes)
    {
        foreach($routes as $route) {
            $explode = explode('@', $route[1]);
            if(isset($route[2])) {
                $arr = [$route[0], $explode[0], $explode[1], $route[2]];
            } else {
                $arr = [$route[0], $explode[0], $explode[1]];
            }
            $newRoutes[] = $arr; 
        }

        $this->routes = $newRoutes;
    }

    private function getRequests()
    {
        $obj = new \stdClass;

        $get=(object)$_GET;
        $post=(object)$_POST;

        $obj->get=$get;
        $obj->post=$post;

        return $obj;
    }
    
    private function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function run() 
    {   
        $url = $this->getUrl();
        $urlArray = explode('/', $url);

        foreach($this->routes as $route) {
            $routeArray = explode('/', $route[0]);
            $params = [];
            for($i = 0; $i < count($routeArray); $i++) {
                if(strpos($routeArray[$i], "{") !== false && strpos($routeArray[$i], "}") !== false && count($urlArray) == count($routeArray)) {
                    $routeArray[$i] = $urlArray[$i];
                    $params[] = $urlArray[$i];
                }
                $route[0] = implode($routeArray, '/');
            }

            if($url == $route[0]) {
                $found = true;
                $controller = $route[1];
                $action = $route[2];
                $auth = new Auth();
                if(isset($route[3]) && !$auth->isLogged()) {
                    $action = 'forbidden';
                }
                break;
            }
        }
        if(isset($found) && $found) {
            $controller = Container::newController($controller);
            switch (count($params)) {
                case 1:
                    $controller->$action($params[0], $this->getRequests());
                    break;
                case 2:
                    $controller->$action($params[0], $params[1], $this->getRequests());
                    break;
                case 3:
                    $controller->$action($params[0], $params[1], $params[2], $this->getRequests());
                    break;
                default:
                    $controller->$action($this->getRequests());
                    break;
            }
        } else {
            Container::pageNotFound();
        }
    }
}