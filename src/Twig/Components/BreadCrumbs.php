<?php

namespace App\Twig\Components;

use App\Services\Menu\BreadCrumbsBuilder;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BreadCrumbs
{
    public array $breadCrumbs = [];

    public function __construct(private BreadCrumbsBuilder $breadCrumbsBuilder)
    {
        $this->breadCrumbs = $this->breadCrumbsBuilder->getBreadCrumbs();
    }
}
