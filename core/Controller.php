<?php



use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;

class Controller
{
    public function view(string $path, $datas = [])
    {
        $loader = new FilesystemLoader('../ressources/views');
        $twig = new Environment($loader, [
            'cache' => false,
        ]);

        //Etendre une fonction avec twig
        $twig->addFunction(new TwigFunction('route', function ($name, $params = []) {
            return route($name, $params);
        }));

        echo $twig->render($path . '.twig', $datas);
    }
}
