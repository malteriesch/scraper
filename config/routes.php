<?php

use Zend\Filter\Callback as CallbackFilter;

return [
    [

        'name'              => 'extract',
        'route'             => 'extract <url> [--out=] [--config=]',
        'description'       => 'Extract data from a web page',
        'short_description' => 'Extract data from a web list page and related detail pages',
        'defaults'          => [
            'out' => 'out.csv',
            'config' => 'config/default.php',
        ],
        'handler'           => array($this, 'extract')
    ],
];
