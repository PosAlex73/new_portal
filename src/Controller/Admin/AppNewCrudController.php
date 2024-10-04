<?php

namespace App\Controller\Admin;

use App\Entity\AppNew;
use App\Enums\Blog\NewStatuses;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class AppNewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AppNew::class;
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
        $filters->add('created');
        $filters->add('updated');
        $filters->add(ChoiceFilter::new('status')->setChoices($this->getStatusChoices()));

        return $filters;
    }

    private function getStatusChoices(): array
    {
        return [
            'Активно' => NewStatuses::ACTIVE->value,
            'Отключено' => NewStatuses::DISABLED->value,
            'Не опубликовано' => NewStatuses::UNPUBLISHED->value,
            'Отменено' => NewStatuses::CANCELLED->value,
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
         $crud->setSearchFields([
            'title', 'text'
        ]);

         $crud->setPageTitle(Crud::PAGE_INDEX, 'Новости');
         $crud->setPageTitle(Crud::PAGE_EDIT, fn (AppNew $appNew) => $appNew->getTitle());

         $crud->setDefaultSort(['id' => 'DESC']);

         return $crud;
    }
}
