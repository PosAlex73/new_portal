<?php

namespace App\Exceptions;

use Doctrine\DBAL\Exception;

class TemplateNotDefinedException extends Exception
{
    protected $message = 'Шаблон для данного типа задач не определен';
}
