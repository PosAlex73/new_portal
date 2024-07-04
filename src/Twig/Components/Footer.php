<?php

namespace App\Twig\Components;

use App\Services\Elements\MenuElement;
use App\Services\Menu\FooterMenu;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Footer
{
    /**
     * @var MenuElement[]
     */
    public $footerMenu;

    public function __construct(protected FooterMenu $footerMenuService)
    {
        $this->footerMenu = $this->footerMenuService->getFooterMenu();
    }
}
