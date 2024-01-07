<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enums\Users\UserStatuses;
use App\Enums\Users\UserTypes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->setDisabled(),
        ];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = TextField::new('fullName');
        }

        if ($pageName === Crud::PAGE_EDIT || $pageName === Crud::PAGE_DETAIL) {
            $fields[] = TextField::new('firstName');
            $fields[] = TextField::new('lastName');
        }

        $fields[] = EmailField::new('email');
        $fields[] = ChoiceField::new('status')->setChoices([
            'Активно' => UserStatuses::ACTIVE->value,
            'Отключено' => UserStatuses::DISABLED->value,
            'В ожидании' => UserStatuses::PENDING->value,
        ]);

        $fields[] = ChoiceField::new('type')->setChoices([
            'Админ' => UserTypes::ADMIN->value,
            'Обычный' => UserTypes::SIMPLE->value,
        ])->setDisabled();

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = DateTimeField::new('created');
            $fields[] = DateTimeField::new('updated');
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        $chatAction =
            Action::new('showThread', 'Показать чат', null)
                ->linkToRoute('show_thread', function (User $user) {
                    return [
                        'id' => $user->getId()
                    ];
                })
                ->displayIf(static function ($entity) {
                    return !empty($entity);
                });

        $profileAction = Action::new('showProfile', 'Показать профиль', null)
            ->linkToRoute('show_profile', fn (User $user) => [
                'id' => $user->getId()
            ])
            ->displayIf(fn ($entity) => !empty($entity));

        $actions->add(Crud::PAGE_INDEX, $profileAction);
        $actions->add(Crud::PAGE_EDIT, $profileAction);
        $actions->add(Crud::PAGE_INDEX, $chatAction);
        $actions->add(Crud::PAGE_EDIT, $chatAction);

        return $actions;
    }
}
