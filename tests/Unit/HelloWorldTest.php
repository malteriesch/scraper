<?php

namespace Scrapertests\Unit;

class HelloWorldTest extends \ScraperTests\Lib\BaseTestCase
{
    public function test_TestShouldFailToDemonstrateTestWasFound()
    {
        $this->fail("PHPUnit works!");
    }
}
