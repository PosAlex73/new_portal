<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Enums\CommonStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
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
            'Активно' => CommonStatus::ACTIVE->value,
            'Отключено' => CommonStatus::DISABLED->value,
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Категории');
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (Category $category) => $category->getTitle());

        return $crud->setDefaultSort(['updated' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->remove(Crud::PAGE_INDEX, Action::DELETE);
        $actions->remove(Crud::PAGE_DETAIL, Action::DELETE);

        return $actions;
    }
}
