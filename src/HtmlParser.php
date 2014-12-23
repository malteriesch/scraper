<?php

namespace Scraper;

use Symfony\Component\DomCrawler\Crawler;

/**
 * @TODO this class is currently covered by the HtmlScraper SmokeTest, but upon further refactoring should have own tests.
 * @TODO also the api could be improved
 */
class HtmlParser
{

    /**
     * $parsed is assumed to only hold one element
     * @param  \Symfony\Component\DomCrawler\Crawler $parsed
     * @return Stringss
     */
    public function getNodeValue(Crawler $parsed)
    {
        return $parsed->html();
    }

    /**
     * $parsed is assumed to only hold one element
     * @param  \Symfony\Component\DomCrawler\Crawler $parsed
     * @param  String                                $attribute
     * @return String
     */
    public function getNodeAttribute(Crawler $parsed, $attribute)
    {
        return $parsed->getNode(0)->getAttribute($attribute);
    }

    /**
     *
     * @param  String  $html
     * @param  String  $cssSelector
     * @return Crawler
     */
    public function parse($html, $cssSelector)
    {
        $crawler = $this->createCrawler();
        $crawler->addHtmlContent($html);

        return $crawler->filter($cssSelector);
    }

    /**
     * convenience method to extract xml from node
     * @param  \DOMElement $node
     * @return String
     * */
    public function getHtmlFromDomElement(\DOMElement $node)
    {
        return $node->ownerDocument->saveXML($node);
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

}
