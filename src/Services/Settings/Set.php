<?php

namespace App\Services\Settings;

use App\Enums\Settings\SettingEnum;
use App\Repository\SettingRepository;

class Set
{
    private array $settings;

    public function __construct(protected SettingRepository $settingRepository)
    {
        $allSettings = $this->settingRepository->findAll();
        foreach ($allSettings as $setting) {
            $this->settings[$setting->getTitle()] = $setting;
        }
    }

    public function get(SettingEnum $settingEnum)
    {
        return $this->settings[$settingEnum->value];
    }
}
