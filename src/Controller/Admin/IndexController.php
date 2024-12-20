<?php

namespace App\Controller\Admin;

use App\Entity\AppNew;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Course;
use App\Entity\CourseBugReport;
use App\Entity\CourseLink;
use App\Entity\CourseTag;
use App\Entity\Image;
use App\Entity\Page;
use App\Entity\Setting;
use App\Entity\Task;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portal Inc.');
    }

    public function configureMenuItems(): iterable
    {
        $menu  = [
            MenuItem::section('Общий раздел'),
            MenuItem::linkToDashboard('Главная', 'fa fa-home'),
            MenuItem::section('Обучение'),
            MenuItem::linkToCrud('Курсы', 'fa fa-home', Course::class),
            MenuItem::linkToCrud('Задачи', 'fa fa-home', Task::class),
            MenuItem::linkToCrud('Категории', 'fa fa-home', Category::class),
            MenuItem::linkToCrud('Теги', 'fa fa-home', CourseTag::class),
            MenuItem::linkToCrud('Ссылки', 'fa fa-home', CourseLink::class),
            MenuItem::section('Пользователи'),
            MenuItem::linkToCrud('Пользователи', 'fa fa-home', User::class),
            MenuItem::section('Страницы'),
            MenuItem::linkToCrud('Статьи', 'fa fa-home', Article::class),
            MenuItem::linkToCrud('Страницы', 'fa fa-home', Page::class),
            MenuItem::linkToCrud('Новости', 'fa fa-home', AppNew::class),
            MenuItem::linkToCrud('Отчеты об ошибках', 'fa fa-home', CourseBugReport::class),
            MenuItem::section('Система'),
            MenuItem::linkToRoute('Настройки', 'fa fa-home', 'setting_values'),
            MenuItem::linkToCrud('Картинки', 'fa fa-home', Image::class)
        ];

        return $menu;
    }
}
