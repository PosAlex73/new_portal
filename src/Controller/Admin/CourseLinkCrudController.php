<?php

namespace App\Controller\Admin;

use App\Entity\CourseLink;
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
}
