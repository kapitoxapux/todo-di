<?php
namespace App\Entities;

use Twig_Environment;
use Twig_Loader_Filesystem;

class View
{

    private $twig;

    private $loader;

    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem("src/app/Views/");
        $this->twig = new Twig_Environment($this->loader, [
            'debug' => false,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function render($template, $params)
    {

        return $this->twig->render($template, $params);
    }
}
