<?php

namespace Scraper\Console;

use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\Console;
use ZF\Console\Route;

class Application extends \ZF\Console\Application
{

    protected $htmlClient;

    public function __construct()
    {

        parent::__construct("Web Extracter", "1.0", $this->getRouteConfiguration(), Console::getInstance());
    }

    public function getConfiguration($path)
    {
        return include $path;
    }

    /**
     *
     * @return \Scraper\HtmlClient
     */
    protected function getHttpClient()
    {
        return $this->htmlClient;
    }

    protected function setHttpClient(\Scraper\HtmlClient $client)
    {
        $this->htmlClient = $client;
    }

    public function getRouteConfiguration()
    {
        return include 'config/routes.php';
    }

    protected function initDefaultHttpClient($startUrl)
    {
        $this->setHttpClient(new \Scraper\HtmlClient(dirname($startUrl) . '/'));
    }

    public function extract(Route $route, AdapterInterface $console)
    {
        $startUrl   = $route->getMatchedParam('url');
        $outputFile = $route->getMatchedParam('out');
        $this->initDefaultHttpClient($startUrl);
        $config     = $this->getConfiguration($route->getMatchedParam('config'));

        $scraper = new \Scraper\HtmlScraper($this->getHttpClient()->getHtml(basename($startUrl)), $config);

        $scraped   = $scraper->scrape();
        $converted = new \Scraper\Format\Csv();
        file_put_contents($outputFile, $converted->getConverted($scraped));
        $console->writeLine("Completed, data written to $outputFile");
    }

}
