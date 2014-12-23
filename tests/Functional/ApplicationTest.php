<?php

namespace Scrapertests\Unit;

class ApplicationTest extends \ScraperTests\Lib\BaseTestCase
{

    public function test_SmokeTest()
    {
        $tempFile = sys_get_temp_dir() . '/' . md5(uniqid(rand(), true));
        chdir('..');
        $out      = exec('php scrape.php extract tests/Assets/liverpool --config=tests/Assets/test-config.php --out=' . $tempFile);
        $this->assertEquals("Completed, data written to " . $tempFile, $out);
        $this->assertEquals(file_get_contents('tests/Assets/expected.csv'), file_get_contents($tempFile));
    }

    public function test_SmokeTest_Json()
    {
        $tempFile = sys_get_temp_dir() . '/' . md5(uniqid(rand(), true));
        chdir('..');
        $out      = exec('php scrape.php extract tests/Assets/liverpool --config=tests/Assets/test-config.php --format=json --out=' . $tempFile);
        $this->assertEquals("Completed, data written to " . $tempFile, $out);
        $this->assertEquals(file_get_contents('tests/Assets/expected.json'), file_get_contents($tempFile));
    }

    public function test_SmokeTest_InvalidFormat()
    {
        chdir('..');
        $out      = exec('php scrape.php extract tests/Assets/liverpool --config=tests/Assets/test-config.php --format=foo --out=foo.foo');
        $this->assertEquals("Invalid format", trim($out));
    }

    public function test_SmokeTest_InvalidUrl()
    {
        chdir('..');
        $realPath = realpath('tests/Assets');
        $out      = exec('php scrape.php extract tests/Assets/IDoNotExist --config=tests/Assets/test-config.php --format=json --out=foo.json');
        $this->assertEquals("Could not open url $realPath/IDoNotExist.html", trim($out));
    }

    public function test_SmokeTest_InvalidConfigFile()
    {
        chdir('..');
        $out      = exec('php scrape.php extract tests/Assets/liverpool --config=tests/Assets/i-do-not-exist.php --format=json --out=foo.json');
        $this->assertEquals("Could not open config tests/Assets/i-do-not-exist.php", trim($out));
    }

    public function test_SmokeTest_InvalidOutputFile()
    {
        chdir('..');
        $out = exec('php scrape.php extract tests/Assets/liverpool --config=tests/Assets/test-config.php --format=json --out=/thisIsBadFolder/foo.json');
        $this->assertEquals("Could not write to file /thisIsBadFolder/foo.json", trim($out));
    }

}
