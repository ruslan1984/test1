<?php
namespace Model;
use Illuminate\Database\Capsule\Manager as Capsule;

class Model
{
    protected $mysqli;
    
    function __construct() {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'mariadb',
            'database'  => 'test',
            'username'  => 'root',
            'password'  => 'root',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }    
}