<?php namespace Jralph\PHPCSVParser\Facades;

use Illuminate\Support\Facades\Facade;
use Jralph\PHPCSVParser\ParserManager;

class Parser extends Facade {

    protected static function getFacadeAccessor()
    {
        return new ParserManager;
    }

}