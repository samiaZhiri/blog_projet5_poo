<?php

use App\https\HttpRequest;

class Request
{
    private $path;
    private $action;
    private $params = [];
    private $request;
    private $routeName;
    //comme la class Route prend 2 paramètres ($path et $action)
    //j'aurai besoin d'un constructeur
    public function __construct(string $path, string $action)
    {
        $this->request = new HttpRequest();
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    public function name(string $name = null)
    {
        //chaque name d'une route va correspondre un $path
        //cette fonction me retourne un tableau avec une clé indexé
        $this->routeName[$name][] = $this->path;
        return $this->routeName;
    }

    public function match($url)
    {
        //je veux faire le traitement de mon match
        //je veux remplacer {id} par une expression régulière
        $path = preg_replace('#({[\w]+})#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";

        if (preg_match($pathToMatch, $url, $results)) {
            //ds $results jaurai le chemin complet de l'url si ca matche
            //et ca va me stocker les paramètres ds un tableau
            //je veux écraser la 1ère valeur du tableau donc l'url complet
            array_shift($results); //le reste ds mon tableau ce sont les paramètres
            //car je viens d'écraser l'url
            $this->params = $results;
            return true;
        } else {
            return false;
        }
    }
    public function execute()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->getRequest();
        } else {
            $this->postRequest();
        }
    }

    public function getRequest()
    {
        //Si c'est un string il m'execute tout ce qu'il ya
        if (is_string($this->action)) {
            $action = explode('@', $this->action);
            $controller = $action[0];
            $controller = new $controller();
            $method = $action[1];
            // return isset($this->params) ? $controller->$method(implode($this->params)) : $controller->$method();
            //Appelle une fonction de rappel avec les paramètres rassemblés en tableau
            call_user_func_array([$controller, $method], $this->params);
            // Sinon il m'execute cela
        } else {
            call_user_func_array($this->action, $this->params);
        }
    }
    public function postRequest()
    {
        if (is_string($this->action)) {
            $action = explode('@', $this->action);
            $controller = $action[0];
            $controller = new $controller();
            $method = $action[1];
            // return isset($this->params) ? $controller->$method($this->request, implode($this->params)) : $controller->$method($this->request);
            //Empile un ou plusieurs éléments au début d'un tableau
            array_unshift($this->params, $this->request);
            call_user_func_array([$controller, $method], $this->params);
        } else {
            call_user_func_array($this->action, $this->params);
        }
    }
}
