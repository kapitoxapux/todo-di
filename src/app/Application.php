<?php

namespace App;

/**
 * Singleton class
 *
 */
final class Application
{

    public static ?Container $inst = null;

    private function __clone(){

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
        if ($this->nstance === null) {
            $inst = App\Containers\Container();
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instantiate it
     *
     */
    private function __construct()
    {
    }

}