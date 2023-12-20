<?php

namespace App;

use App\Containers\Container;

/**
 * Singleton class
 *
 */
final class Application
{

    /**
     * @var Container|null
     */
    private static ?Container $instance = null;


    protected function __clone(){
    }

//    private function __wakeup(){
//
//    }

    /**
     * Call this method to get singleton
     *
     * @return Container
     */
    public static function getInstance(): Container
    {
        if (!self::$instance instanceof Container && is_null(self::$instance)) {
            self::$instance = new Container();
        }
        return self::$instance;
    }

    /**
     * Private, so nobody else can instantiate it
     *
     */
    private function __construct()
    {
    }

}