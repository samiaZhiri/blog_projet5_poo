<?php

//Affiche l'url
function route($name, $params = [])
{
    $path = Route::url($name, $params);
    echo $path;
}

//Redirection
function redirect($name, $params = [])
{
    $path = Route::url($name, $params);
    header('Location:' . $path);
}
