<?php

namespace App\Exceptions;

class ApplicationTerminatedException extends \Exception
{
    protected $message = 'В данный момент проводятся технические работы';
}
