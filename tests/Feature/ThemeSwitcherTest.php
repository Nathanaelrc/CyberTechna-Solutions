<?php

namespace Tests\Feature;

use Tests\TestCase;

class ThemeSwitcherTest extends TestCase
{
    public function test_login_page_renders_theme_switcher_next_to_language_switcher(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('data-theme-switcher', false);
        $response->assertSee('data-theme-option="light"', false);
        $response->assertSee('data-theme-option="dark"', false);
    }
}