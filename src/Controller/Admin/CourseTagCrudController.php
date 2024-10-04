<?php

namespace App\Controller\Admin;

use App\Entity\CourseTag;
use App\Enums\CommonStatus;
use App\Enums\System\TagColors;
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
            ChoiceField::new('status')->setChoices($this->getStatusChoices()),
            ChoiceField::new('color')->setChoices($this->getColorChoices()),
            AssociationField::new('courses')->autocomplete(),
            DateTimeField::new('created')->setDisabled(),
            DateTimeField::new('updated')->setDisabled()
        ];
    }

    private function getStatusChoices(): array
    {
        return [
            'Активно' => CommonStatus::ACTIVE->value,
            'Отключено' => CommonStatus::DISABLED->value
        ];
    }

    private function getColorChoices(): array
    {
        return [
            'Primary' => TagColors::PRIMARY->value,
            'Secondary' => TagColors::SECONDARY->value,
            'Success' => TagColors::SUCCESS->value,
            'Danger' => TagColors::DANGER->value,
            'Dark' => TagColors::DARK->value,
            'Warning' => TagColors::WARNING->value,
            'Light' => TagColors::WARNING->value,
            'Info' => TagColors::INFO->value
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters->add('created');
        $filters->add('updated');
        $filters->add(ChoiceFilter::new('color')->setChoices($this->getColorChoices()));
        $filters->add(ChoiceFilter::new('status')->setChoices($this->getColorChoices()));

        return $filters;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setDefaultSort(['id' => 'DESC']);

        return $crud;
    }
}
