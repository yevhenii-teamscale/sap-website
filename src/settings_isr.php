<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        'token' => 'Prem465#0!7',
        'api_key' => '132ghjjkl34',

        //database settings
        //site management database and user
        'db' => [
            'pdo_string' => 'sqlsrv:Server=10.0.0.5;Database=',
            'user' => 'sa',
            'pass' => 'B1Admin',
            'dbname' => 'Website_SAP_API',
        ],
        //SAP databases and use
       'db_api' => [
           'pdo_string' => 'sqlsrv:Server=10.0.0.5;Database=',
           'user' => 'sa',
           'pass' => 'B1Admin',
            'dbname_site1' => 'Premier_Ltd'
            //,'dbname_site2' => 'AVOLOGI',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app_' .date('m_Y') . '.log',
            'level' => \Monolog\Logger::DEBUG
        ]

    ]
];
