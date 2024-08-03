<?php

namespace App\Tests\Integration\Services\UserProgress;

use App\Tests\Integration\BaseKernelTestCase;
use App\Tests\Traits\ServiceGetter;

class UserProgressResetTest extends BaseKernelTestCase
{
    use ServiceGetter;

    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertEquals(true, true);

    }
}
