<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Enums\CommonStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
        return $filters;
    }

    private function getStatusChoices(): array
    {
        return [
            'Активно' => CommonStatus::ACTIVE->value,
            'Отключено' => CommonStatus::DISABLED->value
        ];
    }
}
