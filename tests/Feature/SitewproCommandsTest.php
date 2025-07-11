<?php

namespace Tests\Feature;


use Tests\TestCase;

/**
 *
 */
class SitewproCommandsTest extends TestCase
{
    /** @test */
    public function it_displays_the_welcome_message()
    {
        $this->artisan('sitewpro:help')
            ->expectsOutput('-------------------------------------')
            ->expectsOutput('Sitewpro Help')
            ->expectsOutput('-------------------------------------')
            ->expectsOutput('Available commands:')
            ->expectsOutput('sitewpro:help  Show this help message')
            ->expectsOutput('-------------------------------------')
            ->assertExitCode(0);

    }
}
