<?php


session_start();
require __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
require 'lib/Init.php';
Init::autoload();
require 'app/route.php';

new RestApi;
