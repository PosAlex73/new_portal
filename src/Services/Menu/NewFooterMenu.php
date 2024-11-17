<?php

namespace App\Services\Menu;

use App\Entity\Article;
use App\Entity\Course;
use App\Enums\DateTimeFormatEnum;
use App\Repository\ArticleRepository;
use App\Repository\CourseRepository;
use App\Services\Elements\MenuElement;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NewFooterMenu
{
    public function __construct(
        protected UrlGeneratorInterface $urlGenerator,
        protected CourseRepository $courseRepository,
        protected ArticleRepository $articleRepository
    )
    {}

    public function getFirstColumn(): array
    {
        $popularCourses = $this->courseRepository->getPopularCourses();
        $menu = [];

        /** @var Course $popularCourse */
        foreach ($popularCourses as $popularCourse) {
            $menu[] = new MenuElement(
                $popularCourse->getTitle(),
                $this->urlGenerator->generate('course_details', ['id' => $popularCourse->getId()])
            );

            end($menu)
                ->setParam('date', $popularCourse->getCreated()->format(DateTimeFormatEnum::SHORT_FORMAT->value));
        }

        return $menu;
    }

    public function getSecondColumn(): array
    {
        $popularArticles = $this->articleRepository->getPopularArticles();

        $menu = [];

        /** @var Article $popularArticle */
        foreach ($popularArticles as $popularArticle) {
            $menu[] = new MenuElement(
                $popularArticle->getTitle(),
                $this->urlGenerator->generate('blog_details', ['id' => $popularArticle->getId()])
            );

            end($menu)
                ->setParam('date', $popularArticle->getCreated()->format(DateTimeFormatEnum::SHORT_FORMAT->value));
        }

        return $menu;
    }

    public function getThirdColumn(): array
    {

    }
}
