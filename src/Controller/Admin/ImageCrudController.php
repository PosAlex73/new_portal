<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Enums\System\ImageTypes;
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
            TextField::new('title'),
            ImageField::new('path')
                ->setBasePath('uploads/images/')
                ->setUploadDir('uploads'),
            ChoiceField::new('type')
                ->setChoices([
                    'Обычное' => ImageTypes::COMMON->value,
                    'Загруженное' => ImageTypes::UPLOAD->value
                ]),
            DateTimeField::new('created')->setDisabled(),
            DateTimeField::new('updated')->setDisabled(),
            TextField::new('extension')->setDisabled()
        ];
    }
}
