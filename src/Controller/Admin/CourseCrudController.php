<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Enums\Courses\CourseStatuses;
use App\Enums\Courses\CourseTypes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

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
            ChoiceField::new('type')->setChoices($this->getStatusChoices()),
            TextField::new('lang')->setDisabled(),
            NumberField::new('position'),
            ChoiceField::new('status')->setChoices($this->getStatusChoices()),
            FormField::addTab('Ссылки и теги'),
            AssociationField::new('courseLinks')
                ->autocomplete()
                ->setCrudController(CourseLinkCrudController::class)
                ->setFormTypeOptions([
                    'by_reference' => false
                ]),
            AssociationField::new('courseTags')
                ->autocomplete()
                ->setCrudController(CourseTagCrudController::class)
                ->setFormTypeOptions([
                    'by_reference' => false
                ])
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = DateTimeField::new('created')
                ->setDisabled();
            $fields[] = DateTimeField::new('updated')
                ->setDisabled();
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        $courseCallback = fn(Course $course) => ['id' => $course->getId()];
        $showTasksAction = Action::new('showTasks', 'Посмотреть задачи')
            ->linkToRoute('show_tasks', $courseCallback);

        $editCourseAction = Action::new('editCourse', 'Содержание курса')
            ->linkToRoute('editCourse', $courseCallback);

        $actions->remove(Crud::PAGE_INDEX, Action::NEW);
        $actions->remove(Crud::PAGE_INDEX, Action::DELETE);

        $actions->add(Crud::PAGE_INDEX, $showTasksAction);
        $actions->add(Crud::PAGE_EDIT, $showTasksAction);

        $actions->add(Crud::PAGE_INDEX, $editCourseAction);
        $actions->add(Crud::PAGE_EDIT, $editCourseAction);

        return $actions;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters->add('created');
        $filters->add('updated');
        $filters->add(ChoiceFilter::new('status')->setChoices($this->getStatusChoices()));
        $filters->add(ChoiceFilter::new('type')->setChoices($this->getTypeChoices()));

        return $filters;
    }

    private function getStatusChoices(): array
    {
        return [
            'Активно' => CourseStatuses::ACTIVE->value,
            'Отключено' => CourseStatuses::DISABLED->value,
            'В разработке' => CourseStatuses::IN_DEVELOPMENT->value,
            'В архиве' => CourseStatuses::ARCHIVED->value,
        ];
    }

    private function getTypeChoices(): array
    {
        return [
            'Бесплатно' => CourseTypes::FREE->value,
            'Платно' => CourseTypes::PAY->value,
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Курсы');
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (Course $course) => $course->getTitle());

        return $crud;
    }
}
