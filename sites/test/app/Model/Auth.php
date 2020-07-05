<?php
namespace Model;
use \Illuminate\Database\Capsule\Manager as Capsule;


class Auth extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function login($user, $password):bool
    {
        if(($user==='admin')&&($password==='123')){
            return true;
        }
        return false;
    }
}
