<?php

namespace App\Enums\Settings;

enum SettingTypes: string
{
    case Text = 'text';
    case Number = 'number';
    case Choice = 'choice';
    case Textarea = 'textarea';
    case Select = 'select';
}
