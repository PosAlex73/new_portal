<?php

namespace App\Services\Settings;

use App\Entity\Setting;
use App\Enums\Settings\SettingEnum;
use App\Repository\SettingRepository;

class Set
{
    private array $settings = [];

    public function __construct(protected SettingRepository $settingRepository)
    {
        $allSettings = $this->settingRepository->findAll();
        foreach ($allSettings as $setting) {
            $this->settings[$setting->getTitle()] = $setting;
        }
    }

    /**
     * @param SettingEnum $settingEnum
     * @return Setting
     */
    public function get(SettingEnum $settingEnum)
    {
        return $this->settings[$settingEnum->value];
    }

    public function getGithubLink(): string
    {
        return $this->get(SettingEnum::GITHUB_LINK)->getValue();
    }

    public function getShortProjectDescription(): string
    {
        return $this->get(SettingEnum::PROJECT_SHORT_DESCRIPTION)->getValue();
    }

    public function getAdminPublicEmail(): string
    {
        return $this->get(SettingEnum::ADMIN_PUBLIC_EMAIL)->getValue();
    }

    public function getFrontSite(): string
    {
        return $this->get(SettingEnum::FRONT_SITE)->getValue();
    }
}
