<?php

namespace Service;

use \Model\Auth;

class AuthService
{
    private $authModel;

    function __construct()
    {
        $this->authModel = new Auth();
    }
    public function login($user, $password): bool
    {
        $login = $this->authModel->login($user, $password);
        if($login){
            $_SESSION['auth']=true;
        }else{
            $_SESSION['auth']=false;
        }
        return $login;
    }
    public function logout():void{
        $_SESSION['auth']=false;
    }
    public static function isAuth():bool{
        return $_SESSION['auth']??true;
    }
}
