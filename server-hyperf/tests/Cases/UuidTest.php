<?php

namespace HyperfTests\Cases;

use HyperfTests\HttpTestCase;
use Ramsey\Uuid\Uuid;

class UuidTest extends HttpTestCase
{
    public function testUuid4Gen()
    {
        $uuid4 = Uuid::uuid4();
        var_dump($uuid4);
        $this->assertGreaterThan(0, strlen($uuid4));
    }
}