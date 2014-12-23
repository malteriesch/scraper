<?php

namespace Scrapertests\Unit;

use Scraper\HtmlClient;

class HtmlClientTest extends \ScraperTests\Lib\BaseTestCase
{

    public function test_SmokeTest()
    {
        $client = new HtmlClient(TEST_ASSETS);
        $this->assertEquals(file_get_contents(TEST_ASSETS . 'sample.html'), $client->getHtml( 'sample.html'));
    }

    function test_PagesGetCached()
    {
        $basePath = 'vfs://mockfs/';
        if (!file_exists($basePath)) {
            mkdir($basePath);
        }
        
        $client = new HtmlClient($basePath);
        
        file_put_contents('vfs://mockfs/test.html','test html');
        $this->assertEquals('test html', $client->getHtml('test.html'));

        file_put_contents('vfs://mockfs/test.html','test html edited');
        $this->assertEquals('test html', $client->getHtml('test.html'));
    }
}
