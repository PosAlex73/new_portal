<?php

namespace App\Controller\Admin;

use App\Entity\CourseTag;
use App\Enums\CommonStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CourseTagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CourseTag::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('title'),
            ChoiceField::new('status')->setChoices([
                'Активно' => CommonStatus::ACTIVE->value,
                'Отключено' => CommonStatus::DISABLED->value
            ]),
            AssociationField::new('courses')->autocomplete(),
            DateTimeField::new('created')->setDisabled(),
            DateTimeField::new('updated')->setDisabled()
        ];
    }
}
