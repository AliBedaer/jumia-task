<?php
return [
    "default"   =>  "sqlite",
    'connections' => [
        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => env('DB_DATABASE', base_path('database/sample.db')),
            'prefix'   => env('DB_PREFIX', ''),
        ]
    ]
];
