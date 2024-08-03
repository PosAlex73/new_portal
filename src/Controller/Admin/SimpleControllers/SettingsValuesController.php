<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Enums\Settings\SettingTabs;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class SettingsValuesController extends AbstractController
{
    public function __construct(private SettingRepository $settingRepository)
    {
    }

    #[Route('/admin/settings-values/', name: 'setting_values')]
    public function settingValues()
    {
        $settings = $this->settingRepository->fillByTabs();
        $settingTabs = SettingTabs::cases();

        return $this->render('admin/settings/index.html.twig', [
            'settings' => $settings,
            'settingTabs' => $settingTabs
        ]);
    }
}
