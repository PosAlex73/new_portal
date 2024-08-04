<?php

namespace App\Controller\Admin\SimpleControllers;

use App\Controller\Front\Traits\BackUrl;
use App\Enums\Settings\SettingTabs;
use App\Repository\SettingRepository;
use App\Services\Settings\SettingsSaver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SettingsValuesController extends AbstractController
{
    use BackUrl;

    public function __construct(
        private SettingRepository $settingRepository,
        private SettingsSaver $settingsSaver
    ){}

    #[Route('/admin/settings-values/', name: 'setting_values', methods: ['POST', 'GET'])]
    public function settingValues(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            /** @var array<string, string> $settings */
            $settings = $request->get('settings');
            $this->settingsSaver->saveSettings($settings);

            $this->redirect($this->getBackUrl($request));
        }

        $settings = $this->settingRepository->fillByTabs();
        $settingTabs = SettingTabs::cases();

        return $this->render('admin/settings/index.html.twig', [
            'settings' => $settings,
            'settingTabs' => $settingTabs
        ]);
    }
}
