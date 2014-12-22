<?php

namespace Scrapertests\Unit;

/**
 * For simplicity, all filter tests can live here for the moment, they can always be refactored
 */
class FilterTest extends \ScraperTests\Lib\BaseTestCase
{
    public function test_Trim()
    {
        $filter = new \Scraper\Filter\Trim();
        $this->assertEquals("this is trimmed", $filter("  this is trimmed    "));
    }
    
    public function test_CollapseWhiteSpace()
    {
        $filter = new \Scraper\Filter\CollapseWhiteSpace();
        $this->assertEquals("this has whitespace removed", $filter("this has     whitespace \n\n removed"));
        $this->assertEquals(" this has whitespace removed ", $filter(" this has     whitespace \nremoved "), 'it does not trim');
        $this->assertEquals(" this has whitespace removed ", $filter("   this has     whitespace \nremoved\n     "), 'it will also reduce whitespace to one at the start and end');
    }
}
