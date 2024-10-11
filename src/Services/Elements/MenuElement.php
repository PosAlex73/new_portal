<?php

namespace App\Services\Elements;

class MenuElement
{
    private array $params = [];

    public function __construct(
        public string $title,
        public string $route,
        public string $icon = '',
        public null|int $number = null,
        public array $children = []
    )
    {
    }

    public function setParam(string $title, mixed $value)
    {
        $this->params[$title] = $value;
    }

    public function getParam(string $title)
    {
        return array_key_exists($title, $this->params) ? $this->params[$title] : null;
    }
}
