<?php

namespace App\Enums\Settings;

enum SettingTabs: string
{
    case ADMIN = 'admin';
    case FRONT = 'front';
    case SYSTEM = 'system';
    case COMMON = 'common';
    case REGISTRATION_TYPES = 'registration_types';
}
