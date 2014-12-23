<?php

require "Bootstrap.php";


$application = new \Scraper\Console\Application();

exit($application->run());
return;

//$httpClient = new \Scraper\HtmlClient('http://www.unite-students.com/');
define('TEST_ASSETS', __DIR__.'/tests/Assets/'); $httpClient = new \ScraperTests\Lib\TestHttpClient();

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
            'filters'   => [new \Scraper\UniteStudents\Filter\RetrieveFromDetailPage('ul.rooms__list h3.tabs__tab__header__name', $httpClient)]
        ]
    ],
    "list-selector"   => 'section.listing-filter ul.nav li'
];

$scraper = new \Scraper\HtmlScraper($httpClient->getHtml('liverpool'), $configuration);

var_dump($scraper->scrape());
