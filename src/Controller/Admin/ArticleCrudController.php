<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Enums\Blog\BlogStatuses;
use App\Enums\CommonStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id', 'ID')->setDisabled(),
            TextField::new('title', 'Заголовок'),
            TextEditorField::new('text', 'Содержимое'),
            ChoiceField::new('status', 'Статус')->setChoices($this->getStatusChoices())
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = DateTimeField::new('created', 'Создано');
            $fields[] = DateTimeField::new('updated', 'Обновлено');
        }

        return $fields;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters->add(ChoiceFilter::new('status')->setChoices($this->getStatusChoices()));
        $filters->add('created');
        $filters->add('updated');

        return $filters;
    }

    private function getStatusChoices(): array
    {
        return [
            'Активно' => BlogStatuses::ACTIVE->value,
            'Отключено' => BlogStatuses::DISABLED->value,
            'Не опубликовано' => BlogStatuses::UNPUBLISHED->value,
            'Отменено' => BlogStatuses::CANCELLED->value,
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setDefaultSort(['created' => 'DESC']);
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Статьи');
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (Article $article) => $article->getTitle());

        return $crud;
    }
}
