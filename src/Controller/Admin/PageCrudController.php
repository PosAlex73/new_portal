<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Enums\CommonStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->setDisabled(),
            TextField::new('title', 'Заголовок'),
            TextEditorField::new('text', 'Содержимое'),
            ChoiceField::new('status', 'Статус')->setChoices($this->getStatusChoices()),
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = DateTimeField::new('created', 'Создано');
            $fields[] = DateTimeField::new('updated', 'Обновлено');
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::DELETE);
        $actions->disable(Action::NEW);

        return parent::configureActions($actions);
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Страницы');
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (Page $page) => $page->getTitle());
        $crud->setDefaultSort(['id' => 'DESC']);

        return $crud;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters->add('created');
        $filters->add('updated');
        $filters->add(ChoiceFilter::new('status')->setChoices($this->getStatusChoices()));

        return $filters;
    }

    public function getStatusChoices(): array
    {
        return [
            'Активно' => CommonStatus::ACTIVE->value,
            'Отключено' => CommonStatus::DISABLED->value
        ];
    }
}
