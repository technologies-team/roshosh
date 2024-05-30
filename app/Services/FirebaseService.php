<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;
use Lcobucci\JWT\UnencryptedToken;

class FirebaseService
{
    protected $auth;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(storage_path('app\\firebase-auth.json'));

        $this->auth = $firebase->createAuth();
    }

    public function verifyIdToken($idToken): ?UnencryptedToken
    {
        try {
            dd( $this->auth->verifyIdToken($idToken));
        } catch (\InvalidArgumentException $e) {
            // Token is invalid
            return null;
        }
    }
}
