<?php
//include ("Sugarcrm.class.php");

spl_autoload_register( function ( $className ){
    $classPath = str_replace(
        array( "_",  "\\"),
        DIRECTORY_SEPARATOR,
        $className
    ).'.php';
    //$classPath = $className.".php";
//    echo $classPath;
    require $classPath;
    
}); 

require_once __DIR__ . '/vendor/autoload.php';
