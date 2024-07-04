<?php

namespace App\Services\Elements;

class MenuElement
{
    public function __construct(
        public string $title,
        public string $route,
        public string $icon = '',
        public null|int $number = null,
        public array $children = []
    )
    {
    }
}
