<?php

namespace App\Services\Pages;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PageContentGetter
{
    private string $pageContentPath;

    public function __construct(
        private ParameterBagInterface $parameterBag
    ){
        $this->pageContentPath = $this->parameterBag->get('page_path');
    }

    public function getPageContent(string $page)
    {
        $fullPath = $this->pageContentPath . $page . '.html';
        if (file_exists($fullPath) && is_readable($fullPath)) {
            $content = file_get_contents($fullPath);
        }

        return $content;
    }
}
