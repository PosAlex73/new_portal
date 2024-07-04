<?php

namespace App\Services\Menu;

use App\Services\Elements\MenuElement;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FooterMenu
{
    public function __construct(
        protected UrlGeneratorInterface $urlGenerator,
        protected FooterMenuGetter $footerMenuGetter
    )
    {
    }

    public function getFooterMenu(): array
    {
        $footerMenu = $this->footerMenuGetter->getFooterMenuData();
        $elementsData = [];

        foreach ($footerMenu as $elementDto) {
            $elementsData[] = new MenuElement($elementDto->getTitle(), $this->urlGenerator->generate($elementDto->getRouteName()));
        }

        return $elementsData;
    }
}
