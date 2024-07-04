<?php

namespace App\Services\Menu;

use App\Dto\Menu\FooterMenuElementDto;

class FooterMenuGetter
{
    public function getFooterMenuData()
    {
        return [
            new FooterMenuElementDto('about_us', 'О нас', 'about_us'),
            new FooterMenuElementDto('help', 'Помощь', 'help'),
            new FooterMenuElementDto('service_statement', 'Сервисное соглашение', 'service_statement'),
        ];
    }
}
