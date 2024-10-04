<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Enums\CommonStatus;
use App\Enums\Task\TaskTypes;
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
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class TaskCrudController extends AbstractCrudController
{
    public function __construct(
        protected AdminUrlGenerator $adminUrlGenerator,
        protected AdminContextProvider $adminContextProvider
    )
    {

    }

    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->setDisabled(),
            TextField::new('title', 'Заголовок'),
            TextEditorField::new('text', 'Содержимое'),
            ChoiceField::new('status', 'Статус')->setChoices($this->getStatusChoices()),
            ChoiceField::new('type', 'Тип')->setChoices($this->getTypeChoices())->setDisabled(),
            AssociationField::new('course', 'Курс')->setDisabled()
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = DateTimeField::new('created');
            $fields[] = DateTimeField::new('updated');
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->remove(Crud::PAGE_INDEX, Action::NEW);
        $actions->remove(Crud::PAGE_INDEX, Action::DELETE);


        $editTests = Action::new('editTest', 'Редактировать тесты', null)
            ->linkToRoute('edit_test_text', fn (Task $task) => [
                'id' => $task->getId()
            ]);

        $actions->add(Crud::PAGE_INDEX, $editTests);

        return $actions;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters
            ->add(ChoiceFilter::new('type')
                ->setChoices($this->getTypeChoices())
            );

        $filters->add(ChoiceFilter::new('status')->setChoices($this->getStatusChoices()));
        $filters->add('created');
        $filters->add('updated');

        return $filters;
    }

    public function getStatusChoices(): array
    {
        return [
            'Активно' => CommonStatus::ACTIVE->value,
            'Отключено' => CommonStatus::DISABLED->value,
        ];
    }

    public function getTypeChoices(): array
    {
        return [
            'Тест' => TaskTypes::TEST->value,
            'Практика' => TaskTypes::PRACTICE->value,
            'Теория' => TaskTypes::THEORY->value,
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setDefaultSort(['updated' => 'DESC']);
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Задачи');
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (Task $task) => $task->getTitle());

        return $crud;
    }
}
