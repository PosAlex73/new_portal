<?php

namespace App\Services\Settings;

use App\Enums\CommonStatus;
use App\Enums\Settings\SettingEnum;
use App\Enums\Settings\SettingTabs;
use App\Enums\Settings\SettingTypes;

class SettingsCreator
{
    public function getInitialSettings()
    {
        return [
            SettingTabs::ADMIN->value => [
                SettingEnum::ADMIN_PAGINATION->value => [
                    'value' => 20,
                    'type' => SettingTypes::Number->value
                ]
            ],
            SettingTabs::FRONT->value => [
                SettingEnum::FRONT_PAGINATION->value => [
                    'value' => 20,
                    'type' => SettingTypes::Number->value
                ],
                SettingEnum::HERO->value => [
                    'value' => '',
                    'type' => SettingTypes::Textarea->value
                ],
                SettingEnum::MAX_REPORTS->value => [
                    'value' => 5,
                    'type' => SettingTypes::Number->value
                ]
            ],
            SettingTabs::COMMON->value => [
                SettingEnum::PAGE_TITLE->value => [
                    'value' => '',
                    'type' => SettingTypes::Text->value
                ]
            ],
            SettingTabs::COMMON->value => [
                SettingEnum::APP_ENABLED->value => [
                    'value' => CommonStatus::ACTIVE->value,
                    'type' => SettingTypes::Select->value
                ]
            ],
            SettingTabs::REGISTRATION_TYPES->value => [
                SettingEnum::REGISTER_ENABLED->value => [
                    'value' => CommonStatus::ACTIVE->value,
                    'type' => SettingTypes::Select->value
                ],
                SettingEnum::REGISTRATION_GOOGLE->value => [
                    'value' => CommonStatus::DISABLED->value,
                    'type' => SettingTypes::Select->value
                ],
                SettingEnum::REGISTRATION_VK->value => [
                    'value' => CommonStatus::DISABLED->value,
                    'type' => SettingTypes::Select->value
                ],
                SettingEnum::REGISTRATION_YANDEX->value => [
                    'value' => CommonStatus::DISABLED->value,
                    'type' => SettingTypes::Select->value
                ]
            ]
        ];
    }
}
