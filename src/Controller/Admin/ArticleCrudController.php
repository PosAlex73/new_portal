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
            IdField::new('id')->setDisabled(),
            TextField::new('title'),
            TextEditorField::new('text'),
            ChoiceField::new('status')->setChoices($this->getStatusChoices())
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = DateTimeField::new('created');
            $fields[] = DateTimeField::new('updated');
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
}
