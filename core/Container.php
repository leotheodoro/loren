<?php

namespace Core;

use Core\Database;

class Container 
{
    public static function newController($controller)
    {
        $controller = "App\\Controllers\\" . $controller; 
        return new $controller;      
    }

    public static function getModel($model) 
    {
        $model = "App\\Models\\" . $model;
        return new $model(Database::getDatabase());
    }

    public static function pageNotFound()
    {
        if(file_exists(__DIR__."/../app/views/404.phtml")) {
            return require_once __DIR__."/../app/views/404.phtml";
        } else {
            echo "<h1> Erro 404 - Página não encontrada </h1>";
        }
    }
}