<?php

namespace App\Services\Settings;

use App\Repository\SettingRepository;
use Doctrine\ORM\EntityManagerInterface;

class SettingsSaver
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected SettingRepository $settingRepository
    ){}

    public function saveSettings(array $settings)
    {
        $settingEntities = $this->settingRepository->findAll();

        foreach ($settingEntities as $settingEntity) {
            $settingEntity->setValue(
                $settings[$settingEntity->getTitle()]
            );
        }

        $this->entityManager->flush();
    }
}
