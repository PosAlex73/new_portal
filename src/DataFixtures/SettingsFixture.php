<?php

namespace App\DataFixtures;

use App\Entity\Setting;
use App\Services\Settings\SettingsCreator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class SettingsFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        protected SettingsCreator $settingsCreator,
    ){}

    public function load(ObjectManager $manager): void
    {
        $initialSettings = $this->settingsCreator->getInitialSettings();
        foreach ($initialSettings as $tab => $tabContent) {
            foreach ($tabContent as $title => $setting) {
                $newSetting = new Setting();
                $newSetting->setTitle($title);
                $newSetting->setValue($setting['value']);
                $newSetting->setType($setting['type']);
                $newSetting->setTab($tab);
                $newSetting->setUpdated(new \DateTime());

                $manager->persist($newSetting);
                $manager->flush();
            }
        }
    }

    public static function getGroups(): array
    {
        return ['g1'];
    }
}
