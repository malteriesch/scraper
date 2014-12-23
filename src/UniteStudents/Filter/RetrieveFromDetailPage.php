<?php

namespace Scraper\UniteStudents\Filter;
/**
 * Specific filter to take the room types out of array of htmls containing room types and prices
 */
class RetrieveFromDetailPage extends \Scraper\Filter\RetrieveFromDetailPage
{

    public function __invoke($value)
    {
        $nodes = $this->getNodesHtml($value);
        if (0 == count($nodes)) {
            return 'n/a';
        }
        $delimiter = preg_quote('&#13;');
        $results   = [];
        foreach ($nodes as $html) {
            preg_match_all("/$delimiter\s*(.+)$delimiter/", $html, $matches);
            $results[] = $matches[1][0];
        }

        return implode(", ", $results);
    }

}
