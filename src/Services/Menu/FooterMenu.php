<?php

namespace App\Services\Menu;

use App\Services\Elements\MenuElement;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FooterMenu
{
    public function __construct(protected UrlGeneratorInterface $urlGenerator)
    {
    }

    public function getFooterMenu()
    {
        return [
            new MenuElement('О нас', $this->urlGenerator->generate('about_us')),
            new MenuElement('Сервисное соглашение', $this->urlGenerator->generate('service_statement')),
            new MenuElement('Помощь', $this->urlGenerator->generate('help')),
        ];
    }
}
