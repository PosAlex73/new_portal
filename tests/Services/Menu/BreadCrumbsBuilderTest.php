<?php

namespace App\Tests\Services\Menu;

use App\Services\Menu\BreadCrumbsBuilder;
use PHPUnit\Framework\TestCase;

class BreadCrumbsBuilderTest extends TestCase
{

    public function testGetBreadCrumbsIndex()
    {
        $builder = new BreadCrumbsBuilder();
        $builder->addIndexRoute();

        $firstBreadCrumbs = current($builder->getBreadCrumbs());
        $this->assertIsArray($firstBreadCrumbs);
        $this->assertArrayHasKey('title', $firstBreadCrumbs);
        $this->assertArrayHasKey('path', $firstBreadCrumbs);
        $this->assertTrue(in_array('Главная', $firstBreadCrumbs));
        $this->assertTrue(in_array('/', $firstBreadCrumbs));
    }

    public function testGetBreadCrumbs()
    {
        $builder = new BreadCrumbsBuilder();
        $builder->addBreadCrumbs('test_title', 'test_route');
        $bcArray = $builder->getBreadCrumbs();

        $this->assertIsArray($bcArray);
        $bc = current($bcArray);
        $this->assertArrayHasKey('title', $bc);
        $this->assertArrayHasKey('path', $bc);
        $this->assertTrue(in_array('test_title', $bc));
        $this->assertTrue(in_array('test_route', $bc));
    }
}
