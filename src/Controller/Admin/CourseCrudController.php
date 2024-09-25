<?php

namespace App\Controller\Admin;

use App\Admin\Fields\RichEditor;
use App\Entity\Course;
use App\Enums\Courses\CourseStatuses;
use App\Enums\Courses\CourseTypes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CourseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Course::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            FormField::addTab('General'),
            IdField::new('id')->setDisabled(),
            TextField::new('title'),
            TextEditorField::new('short_description'),
            ChoiceField::new('type')->setChoices([
                'Бесплатно' => CourseTypes::FREE->value,
                'Платно' => CourseTypes::PAY->value,
            ]),
            TextField::new('lang')->setDisabled(),
            NumberField::new('position'),
            ChoiceField::new('status')->setChoices([
                'Активно' => CourseStatuses::ACTIVE->value,
                'Отключено' => CourseStatuses::DISABLED->value,
                'В разработке' => CourseStatuses::IN_DEVELOPMENT->value,
                'В архиве' => CourseStatuses::ARCHIVED->value,
            ]),
            FormField::addTab('Edit'),
            RichEditor::new('text'),
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = DateTimeField::new('created');
            $fields[] = DateTimeField::new('updated');
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        $action = Action::new('showTasks', 'Посмотреть задачи')
            ->linkToRoute('show_tasks', fn(Course $course) => ['id' => $course->getId()]);

        $actions->remove(Crud::PAGE_INDEX, Action::NEW);
        $actions->remove(Crud::PAGE_INDEX, Action::DELETE);

        $actions->add(Crud::PAGE_INDEX, $action);
        $actions->add(Crud::PAGE_EDIT, $action);

        return $actions;
    }
}
