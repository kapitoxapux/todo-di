<?php

namespace App\Entities;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig_Environment;
use Twig_Loader_Filesystem;

class View
{

    private Twig_Environment $twig;

    private Twig_Loader_Filesystem $loader;

    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem("src/app/Views/");
        $this->twig = new Twig_Environment($this->loader, [
            'debug' => false,
        ]);
        $this->twig->addExtension(new DebugExtension());
    }

    public function render($template, $params): string
    {

        try {
            return $this->twig->render($template, $params);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
        }
    }
}
