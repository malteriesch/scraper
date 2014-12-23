<?php

namespace Scrapertests\Unit;

class ApplicationTest extends \ScraperTests\Lib\BaseTestCase
{

    public function test_SmokeTest()
    {
        $tempFile = sys_get_temp_dir() . '/' . md5(uniqid(rand(), true));
        chdir('..');
        $out = exec('php scrape.php extract tests/Assets/liverpool.html --config=tests/Assets/test-config.php --out='.$tempFile);
        $this->assertEquals("Completed, data written to ".$tempFile, $out);
        $this->assertEquals(file_get_contents('tests/Assets/expected.csv'), file_get_contents($tempFile));
    }

}
