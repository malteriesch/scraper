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
        if (!file_exists($path)) {
            throw new \Exception("Could not open config " . $path);
        }
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

    /**
     * Main entry point to the application
     * @param \ZF\Console\Route $route
     * @param \Zend\Console\Adapter\AdapterInterface $console
     * @throws \Exception
     */
    public function extract(Route $route, AdapterInterface $console)
    {
        $startUrl    = $route->getMatchedParam('url');
        $outputFile  = $route->getMatchedParam('out');
        $formatClass = '\\Scraper\\Format\\' . ucwords(strtolower($route->getMatchedParam('format')));

        //we set the http client now so that any filters in the configuration can have access to it. I suspect we can find a better way of injecting these though. 
        //Config files can also use $this->setHttpClient to override with their custom version (see test config for example)
        $this->initDefaultHttpClient($startUrl);
        $config = $this->getConfiguration($route->getMatchedParam('config'));

        $scraper = new \Scraper\HtmlScraper($this->getHttpClient()->getHtml(basename($startUrl)), $config);
        $scraped = $scraper->scrape();
        if (!class_exists($formatClass)) {
            throw new \Exception("Invalid format");
        }
        // using variable class names is to be enjoyed with care, but is a good use in this case...
        $converted = new $formatClass();
        if (!is_writable(dirname($outputFile))) {
            throw new \Exception("Could not write to file $outputFile");
        }
        file_put_contents($outputFile, $converted->getConverted($scraped));
        $console->writeLine("Completed, data written to $outputFile");
    }

}
