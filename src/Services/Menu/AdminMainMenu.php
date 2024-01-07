<?php

namespace App\Services\Menu;

use App\Services\Elements\MenuElement;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminMainMenu
{
    public function __construct(protected UrlGeneratorInterface $generator)
    {

    }

    public function getMainMenu()
    {
        return [
            new MenuElement('Курсы', $this->generator->generate('courses_list')),
            new MenuElement('Новости', $this->generator->generate('news_list')),
            new MenuElement('Статьи', $this->generator->generate('blog_list')),
        ];
    }
}
