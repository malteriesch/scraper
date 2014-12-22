<?php

namespace Scraper;

use Symfony\Component\DomCrawler\Crawler;

class HtmlScraper
{

    private $html;
    private $config;
    private $query = null;

    function __construct($html = null, $config = [])
    {
        $this->setHtml($html);
        $this->setConfig($config);
    }

    protected function getHtmlFromDomElement(\DOMElement $node)
    {
        return $node->ownerDocument->saveXML($node);
    }

    public function scrape()
    {
        $listSelector  = $this->getConfig()['list-selector'];
        $itemSelectorConfigs = $this->getConfig()['item-selectors'];
        $listing       = $this->parse($this->getHtml(), $listSelector);

        $results = [];

        foreach ($listing->siblings() as $node) {
            $results[] = $this->getListItemArray($itemSelectorConfigs,$this->getHtmlFromDomElement($node));
        }
        return $results;
    }

    /**
     * @return array
     */
    protected function getListItemArray($itemSelectorConfigs, $nodeHtml)
    {
        $resultingItem = [];
        foreach ($itemSelectorConfigs as $name => $itemSelectorConfig) {
            $content = trim($this->parse($nodeHtml, $itemSelectorConfig['selector'])->html());

            if (isset($this->getConfig()['default-filters'])) {
                $content = $this->runFilters($content, $this->getConfig()['default-filters']);
            }


            $resultingItem[$name] = $content;
        }
        return $resultingItem;
    }

    protected function runFilters($content, array $filters)
    {
        foreach ($filters as $filter) {
            $content = $filter($content);
        }

        return $content;
    }

    /**
     * 
     * @param String $html
     * @param String $cssSelector
     * @return \Zend\Dom\NodeList
     */
    protected function parse($html, $cssSelector)
    {
        $crawler = $this->createCrawler();
        $crawler->addHtmlContent($html);
        return $crawler->filter($cssSelector);
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * by creating the crawler this way, it is still possible to later mock the Crawler 
     * 
     * @return Crawler
     */
    protected function createCrawler()
    {
        return new Crawler();
    }

    /**
     * 
     * @return String
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * 
     * @param String $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }

}
