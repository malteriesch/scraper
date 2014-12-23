<?php

namespace Scraper;

class HtmlScraper
{

    private $html;
    private $config;
    private $query = null;

    public function __construct($html = null, $config = [])
    {
        $this->setHtml($html);
        $this->setConfig($config);
    }

    /**
     * This is the main entry point to the scraper, it assumes that html and configuration have been set
     * @return array
     */
    public function scrape()
    {
        $parser              = $this->createHtmlParser();
        $listSelector        = $this->getConfig()['list-selector'];
        $itemSelectorConfigs = $this->getConfig()['item-selectors'];
        $listing             = $parser->parse($this->getHtml(), $listSelector);

        $results = [];

        //needed to make sure all elements are included.
        //@TODO: there is probably a better way.
        $results[] = $this->getListItemArray($itemSelectorConfigs, $parser->getHtmlFromDomElement($listing->first()->getNode(0)));

        foreach ($listing->siblings() as $node) {
            $results[] = $this->getListItemArray($itemSelectorConfigs, $parser->getHtmlFromDomElement($node));
        }

        return $results;
    }

    /**
     * @return array
     */
    protected function getListItemArray($itemSelectorConfigs, $nodeHtml)
    {
        $parser = $this->createHtmlParser();

        $resultingItem = [];
        foreach ($itemSelectorConfigs as $name => $itemSelectorConfig) {
            $parsed = $parser->parse($nodeHtml, $itemSelectorConfig['selector']);
            if (isset($itemSelectorConfig['attribute'])) {
                $content = $parser->getNodeAttribute($parsed, $itemSelectorConfig['attribute']);
            } else {
                $content = $parser->getNodeValue($parsed);
            }
            if (isset($this->getConfig()['default-filters'])) {
                $content = $this->runFilters($content, $this->getConfig()['default-filters']);
            }
            if (isset($itemSelectorConfig['filters'])) {
                $content = $this->runFilters($content, $itemSelectorConfig['filters']);
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

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * by creating the Parser this way, it is still possible to later mock the Crawler
     *
     * @return HtmlParser
     */
    protected function createHtmlParser()
    {
        return new HtmlParser();
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
