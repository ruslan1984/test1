<?php

/**
 * Обработка маршрутов
 * Class RestApi
 */
class RestApi
{
    private $method;
    private $route;

    function __construct()
    {
        $this->method = $this->method();
        $this->route = $this->route();
        $this->aggregation();
    }

    /**
     * Обработка маршрутов
     */
    private function aggregation()
    {

        switch ($this->method) {
            case 'GET':
                $function = Route::functionGet($this->route);
                $formData = $this->formDataGet();
                self::making($function, $formData);
                break;
            case 'POST':
                $function = Route::functionPost($this->route);
                $formData = $this->formDataPost();
                $formFile = $this->formFile();
                self::making($function, $formData, $formFile);
                break;
            default:
                Response::getResponseText(404);
        }
    }

    private function making($function, $formData = [], $formFile = [])
    {
        try {
            $response = $this->make($function, $formData, $formFile);
            if (is_array($response)) {
                $data = $response['data'] ?? '';
                $status = $response['status'] ?? 200;
            } else {
                $data = $response;
                $status = 200;
            }
            Response::set($data, $status);
        } catch (\Exception $e) {
            Response::set(['error' => $e->getMessage()], $e->getCode());
        }
    }


    /**
     * Текущий тип запроса ( GET, POST, PUT, DELETE )
     * @return string
     */
    private function method(): string
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $method = 'PUT';
            } else {
                throw new \Exception("Unexpected Header");
            }
        }
        return $method;
    }

    /**
     * Текущий маршрут
     * @return string
     */
    private function route(): string
    {
        if (parse_url($_SERVER['REQUEST_URI'])['path'])
            return parse_url($_SERVER['REQUEST_URI'])['path'];
        return '';
    }

    /**
     * Параметры запроса POST
     * @return Array
     */
    private function formDataPost(): array
    {
        $data = file_get_contents('php://input');
        $decoded = json_decode($data, true);
        if (!empty($decoded)) {
            return $decoded;
        }
        parse_str($data, $decoded);
        foreach ($decoded as &$item) {
            $item = htmlspecialchars($item);
        }
        return $decoded ?? [];
    }
    /**
     * Параметры запроса GET
     * @return Array
     */
    private function formDataGet(): array
    {

        $data = $_GET;
        $res = [];
        if (isset($data['q'])) {
            $exp = explode('/', $data['q']);
            foreach ($exp as $item) {
                if (strpos($item, '=') !== false) {
                    list($key, $value) = explode('=', $item);
                    $res[$key] = htmlspecialchars($value);
                }
            }
        }
        foreach ($data as $key => &$item) {
            $res[$key] = htmlspecialchars($item);
        }
        return $res ?? [];
    }

    private function formFile()
    {
        if (empty($_FILES['file'])) {
            return [];
        }
        $array = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/tiff', 'image/gif'
        ];
        if (!in_array($_FILES['file']['type'], $array)) {
            throw new \Exception('Не верный формат файла');
        }
        return $_FILES['file'];
    }

    /**
     * Выполнить метод
     * @param $function
     * @param array $params
     * @return mixed
     */
    private function make($function, $params = [], $file = [])
    {
        $f = explode('@', $function);
        if (count($f) > 1) {
            $namespase =  '\Controller\\';
            $class = $namespase . trim($f[0]);
            $method = trim($f[1]);
            $new = new $class();
            if (method_exists($new, $method)) {
                if (empty($params)) {
                    return $new->$method([]);
                } else {
                    if (empty($file)) {
                        return $new->$method($params);
                    } else {
                        return $new->$method($params, $file);
                    }
                }
            }
        }
        throw new \Exception('Page not found', 404);
    }
}
