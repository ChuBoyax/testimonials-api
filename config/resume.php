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

    // bcrypt hash of the owner password (generate with password_hash / Hash::make)
    'owner_password_hash' => env('RESUME_OWNER_PASSWORD_HASH', ''),

];
