<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;

class RichEditorType extends AbstractType
{
    public function getBlockPrefix()
    {
        return 'rich_editor';
    }
}
