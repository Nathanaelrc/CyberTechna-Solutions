<?php

namespace Tests\Feature;

use Tests\TestCase;

class HttpsProxyTest extends TestCase
{
    public function test_login_form_uses_https_when_request_is_forwarded_as_https(): void
    {
        $response = $this->withServerVariables([
            'HTTP_HOST' => 'secure.cybertechna.test',
            'HTTP_X_FORWARDED_HOST' => 'secure.cybertechna.test',
            'HTTP_X_FORWARDED_PROTO' => 'https',
            'HTTP_X_FORWARDED_PORT' => '443',
            'REMOTE_ADDR' => '10.0.0.10',
        ])->get('/login');

        $response->assertOk();
        $response->assertSee('action="https://secure.cybertechna.test/login"', false);
        $response->assertDontSee('action="http://secure.cybertechna.test/login"', false);
    }
}