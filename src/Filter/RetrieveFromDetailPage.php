<?php

namespace Scraper\Filter;

/**
 * A filter that can in itself traverse to detail pages and select an array of matched html
 */
class RetrieveFromDetailPage implements FilterInterface
{

    protected $httpClient;
    protected $parser;
    protected $selector;

    /**
     *
     * @param String                       $selector   CSS Selector
     * @param \Scraper\HtmlClientInterface $httpClient
     * @param \Scraper\HtmlScraper         $parser
     */
    public function __construct($selector, \Scraper\HtmlClientInterface $httpClient, \Scraper\HtmlParser $parser = null)
    {
        if (null == $parser) {
            $parser = new \Scraper\HtmlParser();
        }
        $this->httpClient = $httpClient;
        $this->parser     = $parser;
        $this->selector   = $selector;
    }

    /**
     *
     * @return Array $path 
     */
    protected function getNodesHtml($path)
    {
        $results = [];

        $nodes = $this->parser->parse($this->httpClient->getHtml($path), $this->selector);
        foreach ($nodes as $node) {
            $html    = $this->parser->getHtmlFromDomElement($node);
            if ($trimmed = trim($html)) {
                $results[] = $trimmed;
            }
        }

        return $results;
    }

    /**
     * Here the $value is a url scraped from a link and represents the detail page
     * @param type $value
     * @return array
     */
    public function __invoke($value)
    {
        return $this->getNodesHtml($value);
    }

}
