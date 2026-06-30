<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Résumé download gate
    |--------------------------------------------------------------------------
    |
    | Credentials that protect the résumé PDF download on the portfolio site.
    | Only the owner (these credentials) may trigger the download. The password
    | is stored as a bcrypt hash so the plaintext never lives in the repo/env.
    |
    */

    'owner_email' => env('RESUME_OWNER_EMAIL', 'dedalboyet16@gmail.com'),

    // bcrypt hash of the owner password (generate with password_hash / Hash::make).
    // The default below lets the gate work in production without extra Vercel env
    // setup; set RESUME_OWNER_PASSWORD_HASH in the environment to override it.
    'owner_password_hash' => env(
        'RESUME_OWNER_PASSWORD_HASH',
        '$2y$12$770382nguFCdFdWGW3hyhu8cv6FlXfNISH4faFO.uXTeLwwX3P/De'
    ),

];
