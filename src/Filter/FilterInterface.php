<?php

namespace Scraper\Filter;

interface FilterInterface {
    /**
     * @param String $value the value to be filtered
     * @return String filtered result
     */
    public function __invoke($value);
}