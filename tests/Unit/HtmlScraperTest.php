<?php

namespace Scrapertests\Unit;

use Scraper\HtmlScraper;

class HtmlScraperTest extends \ScraperTests\Lib\BaseTestCase
{

    public function test_SmokeTest()
    {

        $configuration = [
            "default-filters" => [new \Scraper\Filter\Trim(), new \Scraper\Filter\CollapseWhiteSpace()],
            "item-selectors"  => [
                "Name"  => [
                    'selector' => 'h3.listing-item__caption a'
                ],
                "Price" => [
                    'selector' => '.listing-item__details h3'
                ],
            ],
            "list-selector"   => 'section.listing-filter ul.nav li'
        ];

        $expectedResult = [
            0 => [
                'Price' => 'From £105 per week',
                'Name'  => 'THE RAILYARD',
            ],
            1 => [
                'Price' => 'From £106 per week',
                'Name'  => 'MYRTLE COURT',
            ],
            2 => [
                'Price' => 'From £115 per week',
                'Name'  => 'LENNON STUDIOS',
            ],
            3 => [
                'Price' => 'From £116 per week',
                'Name'  => 'GRAND CENTRAL',
            ],
            4 => [
                'Price' => 'From £121 per week',
                'Name'  => 'CAPITAL GATE',
            ],
            5 => [
                'Price' => 'From £129 per week',
                'Name'  => 'CAMBRIDGE COURT',
            ],
            6 => [
                'Price' => 'Book via university',
                'Name'  => 'APOLLO COURT',
            ],
            7 => [
                'Price' => 'Book via university',
                'Name'  => 'ARRAD HOUSE',
            ],
        ];
        $scraper        = new HtmlScraper(file_get_contents(TEST_ASSETS . 'sample.html'), $configuration);
        $this->assertEquals($expectedResult, $scraper->scrape());
    }

}
