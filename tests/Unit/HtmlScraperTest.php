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
                "Name"      => [
                    'selector' => 'h3.listing-item__caption a'
                ],
                "Price"     => [
                    'selector' => '.listing-item__details h3'
                ],
                "Room Type" => [
                    'selector'  => '.listing-item__details a.listing-item__btn',
                    /* if attribute is ommitted, then by default the node value is used */
                    'attribute' => 'href',
                    'filters'   => [new \Scraper\UniteStudents\Filter\RetrieveFromDetailPage('ul.rooms__list h3.tabs__tab__header__name', new \ScraperTests\Lib\TestHttpClient())]
                ]
            ],
            "list-selector"   => 'section.listing-filter ul.nav li'
        ];

        $expectedResult = [
            [
                'Price' => 'From £99 per week',
                'Name'  => 'LARCH HOUSE',
                'Room Type' => 'Basic non-en-suite, Classic non-en-suite, Premium range 1 non-en-suite, Premium range 1 one bedroom flat'
            ],
            [
                'Price' => 'From £105 per week',
                'Name'  => 'THE RAILYARD',
                'Room Type' => 'Classic en-suite room, Premium range 1 en-suite room'
            ],
            [
                'Price' => 'From £106 per week',
                'Name'  => 'MYRTLE COURT',
                'Room Type' => 'Classic en-suite room'
            ],
            [
                'Price' => 'From £115 per week',
                'Name'  => 'LENNON STUDIOS',
                'Room Type' => 'Classic en-suite room, Premium range 1 en-suite room, Basic studio, Classic studio, Premium range 1 studio'
            ],
            [
                'Price' => 'From £116 per week',
                'Name'  => 'GRAND CENTRAL',
                'Room Type' => 'Basic accessible en-suite, Premium range 1 accessible studio, Classic en-suite room, Basic en-suite room, Premium range 1 en-suite room, Classic non-en-suite room, Classic studio, Premium range 1 studio'
            ],
            [
                'Price' => 'From £121 per week',
                'Name'  => 'CAPITAL GATE',
                'Room Type' => 'Classic en-suite room, Premium range 1 en-suite room, Classic studio'
            ],
            [
                'Price' => 'From £129 per week',
                'Name'  => 'CAMBRIDGE COURT',
                'Room Type' => 'Classic en-suite room'
            ],
            [
                'Price' => 'Book via university',
                'Name'  => 'APOLLO COURT',
                'Room Type' => 'n/a'
            ],
            [
                'Price' => 'Book via university',
                'Name'  => 'ARRAD HOUSE',
                'Room Type' => 'n/a'
            ],
        ];
        $scraper        = new HtmlScraper(file_get_contents(TEST_ASSETS . 'sample.html'), $configuration);
        
        $this->assertEquals($expectedResult, $scraper->scrape());
    }

}
