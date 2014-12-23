<?php

namespace Scrapertests\Lib;

/**
 * Needed because for our local html files we need to append file extensions, otherwise we have a conflict between the asset liverpool (html) and liverpool(folder)
 */
class TestHttpClient extends \Scraper\HtmlClient
{

    public function __construct()
    {
        parent::__construct(TEST_ASSETS);
    }

    /*
     * rewrites the url to use the html in Assets
     */

    public function getHtml($url)
    {
        return parent::getHtml($url . '.html');
    }

}
