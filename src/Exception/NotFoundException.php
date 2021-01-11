<?php

namespace App\Exception;

class NotFoundException extends \Exception
{
    protected $code = 404;

    protected $message = 'Страница не найдена';
}