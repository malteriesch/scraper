<?php

namespace Scraper\Filter;

class Trim implements FilterInterface
{

    public function __invoke($value)
    {
        return trim($value);
    }

}
