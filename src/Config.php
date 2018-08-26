<?php

namespace app;


class Config
{
    public static function load()
    {
        $file = dirname(__DIR__) . '/config/config.php';

        if (file_exists($file)) {

            return include_once $file;
        } else {

            return [];
        }
    }
}