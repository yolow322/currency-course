<?php

namespace App\Core;

use App\Exception\ReadFileException;
use Jenssegers\Blade\Blade;

class View
{
    public static function render(string $view, array $data = [])
    {
        $viewFile = "../resources/views/$view.blade.php";
        if (is_readable($viewFile)) {
            $blade = new Blade('../resources/views', '../resources/cache');
            echo $blade->render($view, $data);
        } else {
            throw new ReadFileException("Невозможно загрузить $viewFile");
        }
    }
}