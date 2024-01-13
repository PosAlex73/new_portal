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
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('text'),
            ChoiceField::new('status')->setChoices([
                'Активно' => CommonStatus::ACTIVE->value,
                'Отключено' => CommonStatus::DISABLED->value,
            ]),
            ChoiceField::new('type')->setChoices([
                'Теория' => TaskTypes::THEORY->value,
                'Тест' => TaskTypes::TEST->value,
                'Практика' => TaskTypes::PRACTICE->value,
            ]),
            AssociationField::new('course')->setDisabled()
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
        return parent::configureFilters($filters)
            ->add(ChoiceFilter::new('type')
                ->setChoices([
                    'Тест' => TaskTypes::TEST->value,
                    'Практика' => TaskTypes::PRACTICE->value,
                    'Теория' => TaskTypes::THEORY->value,
                ])
            );
    }
}
