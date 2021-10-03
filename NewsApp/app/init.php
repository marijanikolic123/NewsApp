<?php
    //
    //require "../app/core/config.php";
    //require  "../app/core/app.php";
    //require  "../app/core/database.php";
    //require  "../app/core/controller.php";
    //require "../app/core/functions.php";
    //require  "../app/core/model.php";
    require 'core/functions.php';
    require 'core/config.php';

    spl_autoload_register('myAutoLoader');

    function myAutoLoader($fileName){
        $path="core/";
        $extension=".php";
        //var_dump($fullPath=$path . $fileName . $extension);
        $fullPath=$path . $fileName . $extension;

        include_once $fullPath;
    }