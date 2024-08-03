<?php

namespace App\Enums\Settings;

enum SettingTypes: string
{
    case Text = 'T';
    case Number = 'N';
    case Choice = 'C';
    case Textarea = 'A';
    case Select = 'S';
}
