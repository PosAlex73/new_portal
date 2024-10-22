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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageCrudController extends AbstractCrudController
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {

    }

    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $baseUploadDir = $this->parameterBag->get('uploads_base_dir');
        $imagesUploadDir = $this->parameterBag->get('uploads_images');

        return [
            IdField::new('id')->setDisabled(),
            TextField::new('title', 'Текст'),
            ImageField::new('path', 'Путь')
                ->setBasePath($baseUploadDir)
                ->setUploadDir($imagesUploadDir),
            ChoiceField::new('type', 'Тип')
                ->setChoices([
                    'Обычное' => ImageTypes::COMMON->value,
                    'Загруженное' => ImageTypes::UPLOAD->value
                ]),
            DateTimeField::new('created', 'Создано')->setDisabled(),
            DateTimeField::new('updated', 'Обновлено')->setDisabled(),
//            TextField::new('url')->setVirtual(true)->formatValue(function (Image $image) {
//                return '123';
//            })
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setDefaultSort(['created' => 'DESC']);
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Картинки');
        $crud->setPageTitle(Crud::PAGE_EDIT, fn (Image $image) => $image->getTitle());

        return $crud;
    }
}
