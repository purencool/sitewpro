<?php

namespace Tests\Unit;

use App\Services\AppDirectoryStructure\HostingEnvironmentBase;
use Tests\TestCase;

class HostingEnvironmentBaseTest extends TestCase
{

    /** @test */
    public function it_creates_a_base_app_directory()
    {
        $manager = new HostingEnvironmentBase();
        $testPath = app_path(
            "/../../". env('HOSTING_SITE_DEFAULT_PATH', 'default_path')
        );
        $this->assertFalse(is_dir($testPath));
        $this->assertTrue($manager->createBaseDirectory());
        $this->assertTrue(is_dir($testPath));
        $this->assertTrue($manager->destroyBaseDirectory());
        $this->assertFalse(is_dir($testPath));
    }

    /** @test */
    public function it_creates_environment_app_directories()
    {
        $manager = new HostingEnvironmentBase();
        $testPath = app_path(
            "/../../". env('HOSTING_SITE_DEFAULT_PATH', 'default_path')
        );
        $this->assertFalse(is_dir($testPath));
        $this->assertTrue($manager->createBaseDirectory());
        $this->assertTrue(is_dir($testPath));
        /*
         * @todo add tests for environments
         */

        $this->assertTrue($manager->destroyBaseDirectory());
        $this->assertFalse(is_dir($testPath));
    }
}
