<?php

namespace App\Admin\Fields;

use App\Form\Type\RichEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class RichEditor implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/fields/rich_editor.html.twig')
            ->setFormType(RichEditorType::class);
    }
}
