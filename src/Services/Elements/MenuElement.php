<?php

namespace App\Services\Elements;

class MenuElement
{
    public function __construct(
        public string $title,
        public string $route,
        public null|int $number = null,
        public array $children = []
    )
    {
    }
}
