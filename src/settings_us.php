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

        //database settings
        //site management database and user 
        'db' => [
            'pdo_string' => 'sqlsrv:Server=localhost;Database=',
            'user' => 'sap_api',
            'pass' => 'SaP@p!?#Z',
            'dbname' => 'Website_SAP_API'
        ],
         //SAP databases and use
        'db_api' => [
            'pdo_string' => 'sqlsrv:Server=localhost;Database=',
            'user' => 'sap_db_read',
            'pass' => 'SaP3ead?#Z',
            'dbname_site1' => 'USA_Primier070614',//USA
            'dbname_site2' => 'gratia_premieruk',//UK
            'dbname_site3' => 'gratia_premier070614'//EU
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app_' .date('m_Y') . '.log',
            'level' => \Monolog\Logger::DEBUG,
        ]
        
    ]
];
