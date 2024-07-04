<?php

namespace App\Dto\Menu;

class FooterMenuElementDto
{
    public function __construct(
        protected string $name,
        protected string $title,
        protected string $routeName,
        protected string $icon = ''
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getRouteName(): string
    {
        return $this->routeName;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }
}
