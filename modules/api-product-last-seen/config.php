<?php

return [
    '__name' => 'api-product-last-seen',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/api-product-last-seen.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/api-product-last-seen' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'product-last-seen' => NULL
            ],
            [
                'api' => NULL 
            ],
            [
                'lib-app' => NULL 
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'ApiProductLastSeen\\Controller' => [
                'type' => 'file',
                'base' => 'modules/api-product-last-seen/controller'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'api' => [
            'apiProductLastSeen' => [
                'path' => [
                    'value' => '/product/seen'
                ],
                'handler' => 'ApiProductLastSeen\\Controller\\Seen::index',
                'method' => 'GET'
            ],
            'apiProductLastSeenTruncate' => [
                'path' => [
                    'value' => '/product/seen'
                ],
                'handler' => 'ApiProductLastSeen\\Controller\\Seen::truncate',
                'method' => 'DELETE'
            ]
        ]
    ]
];