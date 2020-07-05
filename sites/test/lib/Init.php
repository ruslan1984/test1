<?php

class Init
{

  public static function autoload(): void
  {

    spl_autoload_register(function ($class_name) {

      $classPath1 = $_SERVER['DOCUMENT_ROOT'] . "/lib/" . $class_name . ".php";
      if (file_exists($classPath1)) {
        require_once($classPath1);
      }
      $path = $_SERVER['DOCUMENT_ROOT'] . "/app/";
      $classPath = $path . str_replace("\\", "/", $class_name) . '.php';
      if (file_exists($classPath)) {
        require_once($classPath);
        return;
      }
    });
  }
}
