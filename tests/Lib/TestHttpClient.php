<?php

namespace ScraperTests\Lib;

class TestHttpClient extends \Scraper\HtmlClient
{

    public function __construct()
    {
        parent::__construct(TEST_ASSETS . 'liverpool/');
    }


    /*
     * rewrites the url to use the html in Assets
     */
    public function getHtml($url)
    {
        return parent::getHtml(basename($url) . '.html');
    }

}
