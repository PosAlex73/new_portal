<?php

namespace App\Services\Search;

use App\Repository\AppNewRepository;
use App\Repository\ArticleRepository;
use App\Repository\CourseRepository;

class SearchService
{
    protected string $text;

    public function __construct(
        protected CourseRepository $courseRepository,
        protected AppNewRepository $appNewRepository,
        protected ArticleRepository $articleRepository
    ){}

    public function search(string $text)
    {
        $this->text = $text;
        $courses = $this->courseRepository->getBySearch($text);
        $articles = $this->articleRepository->getBySearch($text);
        $news = $this->appNewRepository->getBySearch($text);

        return [
            'courses' => $courses,
            'articles' => $articles,
            'news' => $news
        ];
    }


}
