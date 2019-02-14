<?php

namespace Tests\Functional;

class WelcomeTest extends BaseTestCase
{
    public function testHelloWithoutAuthentication()
    {
        $response = $this->runApp('GET', '/');
        $this->assertEquals($response->getStatusCode(), 401);
    }
}
