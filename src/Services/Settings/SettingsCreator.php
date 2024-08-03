<?php

namespace App\Services\Settings;

use App\Enums\CommonStatus;
use App\Enums\Settings\SettingEnum;
use App\Enums\Settings\SettingTabs;

class SettingsCreator
{
    public function getInitialSettings()
    {
        return [
            SettingTabs::ADMIN->value => [
                SettingEnum::ADMIN_PAGINATION->value => [
                    'value' => 20,
                ]
            ],
            SettingTabs::FRONT->value => [
                SettingEnum::FRONT_PAGINATION->value => [
                    'value' => 20
                ],
                SettingEnum::HERO->value => [
                    'value' => ''
                ],
                SettingEnum::MAX_REPORTS->value => [
                    'value' => 5
                ]
            ],
            SettingTabs::COMMON->value => [
                SettingEnum::PAGE_TITLE->value => [
                    'value' => ''
                ]
            ],
            SettingTabs::COMMON->value => [
                SettingEnum::APP_ENABLED->value => [
                    'value' => CommonStatus::ACTIVE->value
                ]
            ],
            SettingTabs::REGISTRATION_TYPES->value => [
                SettingEnum::REGISTER_ENABLED->value => [
                    'value' => CommonStatus::ACTIVE->value
                ],
                SettingEnum::REGISTRATION_GOOGLE->value => [
                    'value' => CommonStatus::DISABLED->value,
                ],
                SettingEnum::REGISTRATION_VK->value => [
                    'value' => CommonStatus::DISABLED->value
                ],
                SettingEnum::REGISTRATION_YANDEX->value => [
                    'value' => CommonStatus::DISABLED->value
                ]
            ]
        ];
    }
}
