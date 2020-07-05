<?php
session_start();
require __DIR__.'/vendor/autoload.php';
require 'lib/Init.php';
Init::autoload();
require 'app/route.php';

new RestApi;
