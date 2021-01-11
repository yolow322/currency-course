<?php

namespace App\Core;

class Request
{
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function input(string $inputName)
    {
        $request = !empty($_POST) ? $_POST : $_GET;
        foreach ($request as $key => $value) {
            if ($key == $inputName) {
                return $value;
            }
        }
    }
}