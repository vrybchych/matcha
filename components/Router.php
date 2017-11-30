<?php

class Router
{

    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Return request string
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        // get request string
        $uri = $this->getURI();

        // check such request in routes.php
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern$~", $uri)) {

                //get inner route from outer route
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // identify controller and action
                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));

                $parameters = $segments;

                // include file controllers class
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }

                // create object and call method (action)
                $controllerObject = new $controllerName;
                $result =  call_user_func_array(array($controllerObject, $actionName),$parameters);
                if ($result != null) {
                    break;
                }
            }
        }
    }

}