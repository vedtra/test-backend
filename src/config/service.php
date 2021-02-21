<?php

return [

    // firebase service
    'firebase' => [
        'database_url' => env('FIREBASE_DB_URL', ''),
        'project_id' => env('FIREBASE_PROJECT_ID', ''),
        'private_key_id' => env('FIREBASE_PRIVATE_KEY_ID', 'your-key'),
        // replacement needed to get a multiline private key from .env
        'private_key' => str_replace("\\n", "\n", env('FIREBASE_PRIVATE_KEY', '')),
        'client_email' => env('FIREBASE_CLIENT_EMAIL', 'e@email.com'),
        'client_id' => env('FIREBASE_CLIENT_ID', ''),
        'client_x509_cert_url' => env('FIREBASE_CLIENT_x509_CERT_URL', ''),
    ]
];
