<?php

class Route
{
    private static $request;


    public static function get(string $path, string $action)
    {
        /*ca va se charger de faire le traitement des matches
        ensuite quand c'est récupéré on va traiter ca au niveau de run()*/
        $routes = new Request($path, $action);
        //je stocke avec une clé GET
        self::$request['GET'][] = $routes;
        /*je retourne l'instance de Request pour me permettre de faire
        le chaînage aprés*/
        return $routes;
    }
    public static function post(string $path, string $action)
    {
        $routes = new Request($path, $action);
        self::$request['POST'][] = $routes;
        return $routes;
    }
    public static function run()
    {
        /*on va parcourir les routes qu'on a stocké ds $request
         j'ai stocké mes routes en POST et en GET
         Je cherche comment je vais parcourir ca pour que je puisse 
         arriver à matcher avec l'url qui sera passée au niveau du navigateur*/
        foreach (self::$request[$_SERVER['REQUEST_METHOD']] as $route) {
            //je veux matcher la route qu'on a trouvé avec l'url qui est 
            //passée en paramètre au niveau du navigateur
            if ($route->match(trim($_GET['url']), '/')) //methode match qui va devoir
            //matcher le path que j'ai passé et l'url qui est passée au niveau du navigateur
            //trim ->enlève le / en début et en fin, et l'url c'est celui de .htaccess
            {
                //si la route est matché je vais avoir une méthode execute
                //qui va executer tout et nous donner le resultat
                $route->execute();
                die(); //si je trouve ma route je stop ma boucle
            }
        }
        header('HTTP/1.0 404 NOT found');
    }
    public static function url($name, $parameters = [])
    {
        //je dois parcourir toutes mes routes, qui sont stockées ds $request
        foreach (self::$request as $key => $value) {
            //je veux récupérer la clé $key (GET ou POST) et la valeur $value
            foreach (self::$request[$key] as $routes) {
                //Si la clé existe que cette route existe on execute
                if (array_key_exists($name, $routes->name())) {
                    $route = $routes->name();
                    $path = implode($route[$name]);
                    //implode va me convertir le tableau en chaine de caractère
                    //pour me donner ds les routes /home/show/ ou /home/create
                    //maintenant on va tester si le parmetre est vide ou pas
                    if (!empty($parameters)) {
                        //le tableau possède une clé et une valeur ex: ['id'=>1]
                        foreach ($parameters as $key => $value) {
                            //je veux remplacer le paramètre id $key par la valeur dans le $path 
                            $url = str_replace("{{$key}}", $value, $path);
                            return '/' . $url; //je concatène le resultat avec un /
                        }
                    } else { //si le parametre est vide on retourne juste un /
                        return '/' . $path;
                    }
                }
            }
        }
    }
}
