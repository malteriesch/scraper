<?php

namespace Scraper\Format;

class Json implements FormatInterface
{

    public function getConverted($toConvert)
    {

        return json_encode($toConvert);
    }

}
