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
            $fields[] = TextField::new('fullName', 'Полное имя');
        }

        if ($pageName === Crud::PAGE_EDIT || $pageName === Crud::PAGE_DETAIL) {
            $fields[] = TextField::new('firstName', 'Имя');
            $fields[] = TextField::new('lastName', 'Фамилия');
        }

        $fields[] = EmailField::new('email', 'Почта');
        $fields[] = ChoiceField::new('status', 'Статус')->setChoices([
            'Активно' => UserStatuses::ACTIVE->value,
            'Отключено' => UserStatuses::DISABLED->value,
            'В ожидании' => UserStatuses::PENDING->value,
        ]);

        $fields[] = ChoiceField::new('type', 'Тип')->setChoices([
            'Админ' => UserTypes::ADMIN->value,
            'Обычный' => UserTypes::SIMPLE->value,
        ])->setDisabled();

        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = DateTimeField::new('created', 'Создано');
            $fields[] = DateTimeField::new('updated', 'Обновлено');
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        $blockUserAction = Action::new('blockUserAction', 'Заблокировать пользователя', null)
            ->linkToRoute('block_user', fn(User $user) => [
                'id' => $user->getId()
            ])->displayIf(function ($user) {
                return !empty($user) && $user->getType() !== UserTypes::ADMIN->value && $user->getStatus() !== UserStatuses::BANNED->value;
            });

        $unblockUserAction = Action::new('unblockUSerAction', 'Разблокировать пользователя', null)
            ->linkToRoute('unblock_user', fn(User $user) => [
                'id' => $user->getId()
            ])->displayIf(function ($user) {
                return !empty($user) && $user->getType() !== UserTypes::ADMIN->value && $user->getStatus() === UserStatuses::BANNED->value;
            });

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

        $actions->add(Crud::PAGE_INDEX, $blockUserAction);
        $actions->add(Crud::PAGE_EDIT, $blockUserAction);

        $actions->add(Crud::PAGE_INDEX, $unblockUserAction);
        $actions->add(Crud::PAGE_EDIT, $unblockUserAction);

        return $actions;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setDefaultSort(['created' => 'DESC']);
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Пользователи');
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (User $user) => $user->getFullName());

        return $crud;
    }
}
