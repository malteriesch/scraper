<?php

namespace Scraper\Format;

class Csv implements FormatInterface
{

    public function getConverted($toConvert)
    {
        $headers  = array_keys($toConvert[0]);
        $tempFile = sys_get_temp_dir() . '/' . md5(uniqid(rand(), true));
        $fp       = fopen($tempFile, 'w');
        fputcsv($fp, $headers);
        foreach ($toConvert as $fields) {
            fputcsv($fp, $fields, ',', '"');
        }
        fclose($fp);
        $content = trim(file_get_contents($tempFile));
        unlink($tempFile);

        return $content;
    }

}
