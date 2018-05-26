<?php

namespace Core;

abstract class BaseController
{
    protected $view;
    protected $auth;
    protected $errors;
    protected $inputs;
    protected $success;
    private $viewPath;
    private $layoutPath;
    private $pageTitle = null;

    public function __construct()
    {
        $this->view = new \stdClass();
        $this->auth = new Auth();
        if(Session::get('error')) {
            $this->errors = Session::get('error');
            Session::destroy('error');
        }
        if(Session::get('success')) {
            $this->success = Session::get('success');
            Session::destroy('success');
        } 
        if(Session::get('inputs')) {
            $this->inputs = Session::get('inputs');
            Session::destroy('inputs');
        }
    }

    protected function view(string $path, string $layout = null)
    {
        $this->viewPath = $path;
        $this->layoutPath = $layout;
        if($layout) {
            return $this->layout();
        } else {
            return $this->content();
        }
        
    }

    protected function content()
    {
        if(file_exists(__DIR__ . "/../app/views/{$this->viewPath}.phtml")) {
            return require_once __DIR__ . "/../app/views/{$this->viewPath}.phtml";
        } else {
            echo "Error: View path not found";
        }
    }

    protected function layout()
    {
        if(file_exists(__DIR__ . "/../app/views/{$this->layoutPath}.phtml")) {
            return require_once __DIR__ . "/../app/views/{$this->layoutPath}.phtml";
        } else {
            echo "Error: Layout path not found";
        }
    }   
    
    protected function setPageTitle(string $title)
    {
        $this->pageTitle = $title;
    }

    protected function getPageTitle(string $separator = null)
    {
        if($separator) {
            return $this->pageTitle . " " . $separator . " ";
        } else {
            return $this->pageTitle;
        }
    }

    public function forbidden()
    {
        return Redirect::route('/login');
    }


}