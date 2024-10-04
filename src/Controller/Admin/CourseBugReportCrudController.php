<?php

namespace App\Controller\Admin;

use App\Entity\CourseBugReport;
use App\Enums\Courses\BugStatus;
use App\Enums\Users\UserTypes;
use App\Repository\UserRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class CourseBugReportCrudController extends AbstractCrudController
{
    public function __construct(private UserRepository $userRepository)
    {

    }

    public static function getEntityFqcn(): string
    {
        return CourseBugReport::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->setDisabled(),
            TextField::new('title', 'Заголовок'),
            TextEditorField::new('text', 'Содержимое'),
            ChoiceField::new('status', 'Статус')->setChoices($this->getStatusChoices()),
            AssociationField::new('reporter', 'Репортёр')
                ->setQueryBuilder(
                    CourseBugReportCrudController::getUserFilterForReport(...)
                ),
            DateTimeField::new('created', 'Создано')->setDisabled(),
            DateTimeField::new('updated', 'Обновлено')->setDisabled(),
        ];
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if (count($searchDto->getSort()) === 0) {
            $qb->addOrderBy('entity.created', 'DESC');
        }

        return $qb;
    }

    private function getUserFilterForReport()
    {
        return $this->userRepository
            ->createQueryBuilder('u')
            ->where('type', ':type')
            ->setParameters([
                'type' => UserTypes::SIMPLE->value
            ]);
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters->add(
            ChoiceFilter::new('status', 'Статус')
                ->setChoices($this->getStatusChoices())
        );

        $filters->add('created');
        $filters->add('updated');

        return $filters;
    }

    private function getStatusChoices(): array
    {
        return [
            'Новый' => BugStatus::NEW->value,
            'Закрыт' => BugStatus::CLOSE->value,
            'В прогрессе' => BugStatus::IN_PROGRESS->value,
            'Отказано' => BugStatus::REJECT->value,
            'Пофикшено' => BugStatus::FIXED->value
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setDefaultSort(['id' => 'DESC']);
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (CourseBugReport $courseBugReport) => $courseBugReport->getTitle());
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Баг репорты');

        return $crud;
    }
}
