<?php

namespace App\https;

class HttpRequest
{

    public function all()
    {
        return $_POST;
    }
    public function name(string $field)
    {
        //methode qui prend le nom du champs $field et ca 
        //retourne le nom de ce champs là
        return $_POST[$field];
    }
}
