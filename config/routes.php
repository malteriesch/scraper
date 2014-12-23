<?php

return [
    [

        'name'              => 'extract',
        'route'             => 'extract <url> [--out=] [--config=] [--format=]',
        'description'       => 'Extract data from a web page',
        'short_description' => 'Extract data from a web list page and related detail pages',
        'defaults'          => [
            'out' => 'out.csv',
            'config' => 'config/default.php',
            'format' => 'Csv',
        ],
        'handler'           => array($this, 'extract')
    ],
];
