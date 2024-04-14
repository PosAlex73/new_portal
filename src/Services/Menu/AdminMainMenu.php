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
            new MenuElement('Курсы', $this->generator->generate('courses_list'), 'mdi-concourse-ci'),
            new MenuElement('Новости', $this->generator->generate('news_list'), 'mdi-forum-outline'),
            new MenuElement('Статьи', $this->generator->generate('blog_list'), 'mdi-blogger'),
        ];
    }
}
