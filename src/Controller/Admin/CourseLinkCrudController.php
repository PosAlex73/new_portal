<?php

namespace App\Controller\Admin;

use App\Entity\CourseLink;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class CourseLinkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CourseLink::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->setDisabled(),
            TextField::new('title', 'Текст ссылки'),
            UrlField::new('url', 'Ссылка'),
            AssociationField::new('course', 'Курсы')->autocomplete(),
            DateTimeField::new('created', 'Создано')->setDisabled(),
            DateTimeField::new('updated', 'Обновлено')->setDisabled()
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Ссылки');
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (CourseLink $courseLink) => $courseLink->getTitle());

        return $crud;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters->add('created');
        $filters->add('updated');

        return $filters;
    }
}
