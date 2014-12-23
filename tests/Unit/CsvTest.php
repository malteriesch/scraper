<?php

namespace Scrapertests\Unit;

class CsvTest extends \ScraperTests\Lib\BaseTestCase
{

    public function test_getConverted()
    {
        $toConvert = [
            ['col1' => 'a,b', 'col2' => 'row1'],
            ['col1' => 'c'  , 'col2' => 'row2'],
        ];
        $filter    = new \Scraper\Format\Csv();
        $this->assertEquals("col1,col2\n\"a,b\",row1\nc,row2", $filter->getConverted($toConvert));
    }

}
