<?php

namespace Scraper\Filter;

class RetrieveFromDetailPage implements FilterInterface
{

    protected $httpClient;
    protected $parser;
    protected $selector;

    /**
     * 
     * @param String $selector CSS Selector
     * @param \Scraper\HtmlClientInterface $httpClient
     * @param \Scraper\HtmlScraper $parser
     */
    function __construct($selector, \Scraper\HtmlClientInterface $httpClient, \Scraper\HtmlParser $parser = null)
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
     * @return Array $value
     */
    protected function getNodesHtml($path)
    {
        $results = [];
        
        $nodes = $this->parser->parse($this->httpClient->getHtml($path), $this->selector);
        foreach($nodes as $node){
            $html = $this->parser->getHtmlFromDomElement($node);
            if($trimmed = trim($html)){
                $results[] = $trimmed;
            }
        }
        return $results;
    }

    public function __invoke($value)
    {
        return $this->getNodesHtml($value);
    }

}
