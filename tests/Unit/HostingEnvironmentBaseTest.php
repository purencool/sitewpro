<?php

namespace Tests\Unit;

use App\Services\AppDirectoryStructure\HostingEnvironmentBase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class HostingEnvironmentBaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Set up environment variables for testing
        putenv('HOSTING_SITE_DEFAULT_PATH=sitenpro_app');
        putenv('HOSTING_SITE_ENVIRONMENTS="dev,staging,editorial,production"');
    }

    /** @test */
    public function it_gets_the_default_path_name()
    {
        $manager = new HostingEnvironmentBase();
        $this->assertEquals('sitenpro_app', $manager->getBaseDirectoryPathName());
    }

    /** @test */
    public function it_gets_environments_as_array()
    {
        $manager = new HostingEnvironmentBase();
        $expected = ['dev', 'staging', 'editorial', 'production'];
        $this->assertEquals($expected, $manager->getEnvironments());
    }

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
