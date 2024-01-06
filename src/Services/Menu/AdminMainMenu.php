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
            new MenuElement('Пользователи', $this->generator->generate('users_list')),
            new MenuElement('Курсы', $this->generator->generate('courses_list')),
            new MenuElement('Задачи', $this->generator->generate('tasks_list')),
            new MenuElement('Настройки', $this->generator->generate('settings')),
            new MenuElement('Новости', $this->generator->generate('news_list')),
            new MenuElement('Страницы', $this->generator->generate('pages_list')),
            new MenuElement('Статьи', $this->generator->generate('blog_list')),
            new MenuElement('Категории', $this->generator->generate('categories_list')),
        ];
    }
}
