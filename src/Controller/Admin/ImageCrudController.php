<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Enums\System\ImageTypes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('title', 'Текст'),
            ImageField::new('path', 'Путь')
                ->setBasePath('uploads/images/')
                ->setUploadDir('uploads'),
            ChoiceField::new('type', 'Тип')
                ->setChoices([
                    'Обычное' => ImageTypes::COMMON->value,
                    'Загруженное' => ImageTypes::UPLOAD->value
                ]),
            DateTimeField::new('created', 'Создано')->setDisabled(),
            DateTimeField::new('updated', 'Обновлено')->setDisabled(),
            TextField::new('extension', 'Расширение')->setDisabled()
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setDefaultSort(['created' => 'DESC']);
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Rартинки');
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (Image $image) => $image->getTitle());

        return $crud;
    }
}
