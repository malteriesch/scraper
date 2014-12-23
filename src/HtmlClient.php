<?php

namespace Scraper;

/**
 * Default http client
 */
class HtmlClient implements HtmlClientInterface
{

    protected $pages = [];
    protected $baseUrl;

    /**
     *
     * @param String $baseUrl needs to have trailing forward slash /
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getHtml($url)
    {
        if (!isset($this->pages[$url])) {
            if (!file_exists($this->baseUrl . $url)){//covered in functional tests
                throw new \Exception("Could not open url ".$this->baseUrl . $url);
            }
            $this->pages[$url] = file_get_contents($this->baseUrl . $url);
        }

        return $this->pages[$url];
    }

}
