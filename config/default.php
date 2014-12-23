<?php

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
            'filters'   => [new \Scraper\UniteStudents\Filter\RetrieveFromDetailPage('ul.rooms__list h3.tabs__tab__header__name', $this->getHttpClient())]
        ]
    ],
    "list-selector"   => 'section.listing-filter ul.nav li'
];

return $configuration;
