<?php

namespace App\Tests\Traits;

trait MakeMethodPublic
{
    public function makeMethodPublic(object $object, string $method): \ReflectionMethod
    {
        $reflection = new \ReflectionMethod($object, $method);
        $reflection->setAccessible(true);

        return $reflection;
    }
}
