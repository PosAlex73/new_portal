<?php

namespace App\Services\Menu;

class BreadCrumbsBuilder
{
    private array $breadCrumbs = [];

    public function addBreadCrumbs(string $title, string $path)
    {
        $this->breadCrumbs[] = [
            'title' => $title,
            'path' => $path
        ];
    }

    public function getBreadCrumbs()
    {
        return $this->breadCrumbs;
    }

    public function addIndexRoute()
    {
        $this->addBreadCrumbs('Главная', '/');
    }
}
