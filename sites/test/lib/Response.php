<?php

class Response
{
    public static function set($response, $status):void{
        if(!empty($response)){
            echo json_encode($response);
        }
        self::getResponseText($status);
    }
    /**
     * Сформировать заголовки
     */
    public static function setHeaders()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: *");
        // header('Content-Type: application/json;charset=utf-8');
    }

    /**
     * Коды ответов
     */
    public static function getResponseText(int $code)
    {
        self::setHeaders();
        $stateText = [
            200 => 'OK',
            201 => 'Created',
            204 => 'No Content',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error'
        ];
        header("HTTP/1.1 " . $code . " " . $stateText[$code]);
    }


}
