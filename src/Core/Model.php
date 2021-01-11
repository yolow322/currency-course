<?php

namespace App\Core;

use App\Model\Currency;

abstract class Model
{
    protected abstract function save(): void;
}