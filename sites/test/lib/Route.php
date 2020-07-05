<?php

class Route
{

    private static $get = []; // массив функций GET метода
    private static $post = []; // массив функций POST метода
    private static $put = []; // массив функций PUT метода
    private static $delete = []; // массив функций DELETE метода
    private static $patch = []; // массив функций PATCH метода

    /**
     * Добавить маршрут GET метода
     * @param $route
     * @param $method
     */

    public static function get($route, $method): void
    {

        self::$get[$route] = $method;
    }

    /**
     * Добавить маршрут POST метода
     * @param $route
     * @param $method
     */
    public static function post($route, $method): void
    {
        self::$post[$route] = $method;
    }

    /**
     * Добавить маршрут DELETE метода
     * @param $route
     * @param $method
     */
    public static function delete($route, $method): void
    {
        self::$delete[$route] = $method;
    }
    /**
     * Добавить маршрут PUT метода
     * @param $route
     * @param $method
     */
    public static function put($route, $method): void
    {
        self::$put[$route] = $method;
    }

    /**
     * Добавить маршрут PATCH метода
     * @param $route
     * @param $method
     */
    public static function patch($route, $method): void
    {
        self::$patch[$route] = $method;
    }

    /**
     * Возвращает название функции привязанной к методу GET
     * @param $route
     * @return string
     */
    public static function functionGet($route): string
    {
        if (!empty(self::$get[$route])) {
            return self::$get[$route];
        }
        return '';
    }

    /**
     * Возвращает название функции привязанной к методу POST
     * @param $route
     * @return string
     */
    public static function functionPost($route): string
    {
        if (!empty(self::$post[$route])) {
            return self::$post[$route];
        }
        return '';
    }

    /**
     * Возвращает название функции привязанной к методу PUT
     * @param $route
     * @return string
     */
    public static function functionPut($route): string
    {
        if (!empty(self::$put[$route])) {
            return self::$put[$route];
        }
        return '';
    }

    /**
     * Возвращает название функции привязанной к методу PUT
     * @param $route
     * @return string
     */
    public static function functionPatch($route): string
    {
        if (!empty(self::$patch[$route])) {
            return self::$patch[$route];
        }
        return '';
    }

    /**
     * Возвращает название функции привязанной к методу DELETE
     * @param $route
     * @return string
     */
    public static function functionDelete($route): string
    {
        if (!empty(self::$put[$route])) {
            return self::$put[$route];
        }
        return '';
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}
