<?php

namespace Controller;

use Controller\TestController;
use Service\PaginateService;
use Service\AuthService;
use Rakit\Validation\Validator;


class AuthController
{
    private $twig;
    private $validator;
    private $testController;
    function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('resources/views');
        $this->twig = new \Twig\Environment($loader);
        $this->testController =new TestController;
        $this->authService = new AuthService();
        $this->paginateService = new PaginateService();
        $this->validator = new Validator;
    }
    public function index($message = [])
    {
        echo $this->twig->render(
            'auth_page.php',
            [
                'message'   => $message
            ]
        );
    }
    public function login($request = [])
    {
        $validation = $this->validator->make($request, [
            'user'   => 'required',
            'password'  => 'required'
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errors = $validation->errors();
            $message = $errors->firstOfAll();
            self::index($message);
            return;
        }

        $login = $this->authService->login($request['user'], $request['password']);
        if ($login) {
            $message="Вы успешно авторизовались";
            $this->testController->index($request, $message); 
        } else {
            $message = 'Неправильные логин и пароль';
            self::index($message);
        }
    }
    public function logout($request = []){
        $this->authService->logout();
        $this->testController->index(); 
    }
}
