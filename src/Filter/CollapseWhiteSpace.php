<?php

namespace Scraper\Filter;

class CollapseWhiteSpace implements FilterInterface
{
    public function __invoke($value)
    {
        return preg_replace("/\s\s*/", ' ', $value);
    }

}