<?php

namespace App\Twig\Components;

use App\Services\Elements\MenuElement;
use App\Services\Menu\FooterMenu;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class TopMenu
{
    /**
     * @var MenuElement[]
     */
    public $footerMenu;

    public function __construct(protected FooterMenu $footerMenuService)
    {
        $this->TopMenu = $this->footerMenuService->getFooterMenu();
    }
}
