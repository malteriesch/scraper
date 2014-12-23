<?php

namespace Scraper;

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
            $this->pages[$url] = file_get_contents($this->baseUrl . $url);
        }

        return $this->pages[$url];
    }

}
