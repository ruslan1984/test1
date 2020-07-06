<?php

namespace Controller;

use Service\TestService;
use Rakit\Validation\Validator;

class TestController
{
    private $twig;
    private $testService;
    private $validator;

    function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('resources/views');
        $this->twig = new \Twig\Environment($loader);
        $this->testService = new TestService();
        $this->validator = new Validator;
    }
    public function index($request = [], $message = [])
    {   
        $page = 1;
        if (!empty($request['page'])) {
            $page = $request['page'];
        }
        $pageCount = $this->testService->pageCount();
        echo $this->twig->render(
            'home.php',
            [
                'pageCount' => $pageCount,
                'page' => $page,
                'message' => $message,
                'auth' => \Service\AuthService::isAuth()
            ]
        );
    }
    public function data($request = [])
    {
        $clients = [
            'data' => $this->testService->data($request)
        ];
        echo json_encode($clients);
    }
    public function insert($request = [])
    {
        $validation = $this->validator->make($request, [
            'user'   => 'required',
            'email'  => 'required|email',
            'task'   => 'required'
        ]);
        $validation->setMessages([
            'user' => 'Поле имя пусто',
            'email' => 'email не валиден',
            'task' => 'Поле задание пусто',

        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errors = $validation->errors();
            $message =  $errors->firstOfAll();
            self::index($request, $message);
            return;
        }
        if ($this->testService->insert($request)) {
            $message = 'Данные добавленны';
        } else {
            $message = 'Ошибка';
        }
        header('Location: /');
    }
    public function update($request = [])
    {
        if (!\Service\AuthService::isAuth()) {
            echo '-1';
            return;
        }
        $validation = $this->validator->make($request, [
            'id'   => 'required'
        ]);
        $validation->validate();
        if ($validation->fails()) {
            echo '-2';
            return;
        }
        $update = $this->testService->update($request);
        if ($update === 1) {
            echo '1';
        }
    }
}
