<?php

namespace App\Twig\Components;

use App\Services\Menu\AdminMainMenu;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class MainMenu
{
    public array $mainMenu;

    public function __construct(protected AdminMainMenu $menuService)
    {
        $this->mainMenu = $this->menuService->getMainMenu();
    }
}
