<?php

namespace App\Enums\Settings;

enum SettingEnum: string
{
    case APP_ENABLED = 'app_enabled';
    case HERO = 'hero';
    case PAGE_TITLE = 'page_title';
    case REGISTER_ENABLED = 'register_enabled';
    case ADMIN_PAGINATION = 'admin_pagination';
    case FRONT_PAGINATION = 'front_pagination';
}
