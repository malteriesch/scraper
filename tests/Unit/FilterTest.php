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

    public function test_RetrieveFromDetailPage_HasRoomTypes()
    {
        $client = new \ScraperTests\Lib\TestHttpClient();

        $filter = new \Scraper\Filter\RetrieveFromDetailPage('ul.rooms__list h3.tabs__tab__header__name', new \ScraperTests\Lib\TestHttpClient());
        $this->assertEquals([
            '<h3 class="tabs__tab__header__name">&#13;
                      Classic en-suite room&#13;
                      &#13;
                      <span class="tabs__tab__header__remaining"/>&#13;
                      &#13;
                    </h3>',
            '<h3 class="tabs__tab__header__name">&#13;
                      Premium range 1 en-suite room&#13;
                      &#13;
                      <span class="tabs__tab__header__remaining"/>&#13;
                      &#13;
                    </h3>'
                ], $filter('liverpool/the-railyard'));
    }

    public function test_UniteStudents_RetrieveFromDetailPage__HasRoomTypes()
    {
        $client = new \ScraperTests\Lib\TestHttpClient();

        $filter = new \Scraper\UniteStudents\Filter\RetrieveFromDetailPage('ul.rooms__list h3.tabs__tab__header__name', new \ScraperTests\Lib\TestHttpClient());
        $this->assertEquals('Classic en-suite room, Premium range 1 en-suite room', $filter('liverpool/the-railyard'));
    }

    public function test_UniteStudents_RetrieveFromDetailPage_HasNoRoomTypes()
    {
        $client = new \ScraperTests\Lib\TestHttpClient();
        $filter = new \Scraper\UniteStudents\Filter\RetrieveFromDetailPage('ul.rooms__list h3.tabs__tab__header__name', new \ScraperTests\Lib\TestHttpClient());
        $this->assertEquals('n/a', $filter('liverpool/apollo-court'));
    }

}
