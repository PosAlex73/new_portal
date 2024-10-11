<?php

namespace App\Twig\Components;

use App\Services\Menu\NewFooterMenu;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class FooterMenu
{
    public NewFooterMenu $footerMenu;

    public function __construct(protected NewFooterMenu $menu)
    {
        $this->footerMenu = $menu;
    }
}
