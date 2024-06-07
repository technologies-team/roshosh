<?php

namespace App\Services;

use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Messaging;
use Lcobucci\JWT\UnencryptedToken;

class FirebaseService
{
    protected Auth $auth;
    protected Messaging $messagingApp1;
    protected Messaging $messagingApp2;

    public function __construct()
    {
        $firebaseAppCustomer = (new Factory)
            ->withServiceAccount(storage_path('app/key/customer.json'));

        $firebaseAppVendor = (new Factory)
            ->withServiceAccount(storage_path('app/key/vendor.json'));

        $this->auth = $firebaseAppCustomer->createAuth();
        $this->messagingApp1 = $firebaseAppCustomer->createMessaging();
        $this->messagingApp2 = $firebaseAppVendor->createMessaging();
    }

    public function verifyIdToken($idToken): ?UnencryptedToken
    {
        try {
            return $this->auth->verifyIdToken($idToken);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function sendNotificationToAppCustomer(array $message): array
    {
        return $this->messagingApp1->send($message);
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function sendNotificationToAppVendor(array $message): array
    {
        return $this->messagingApp2->send($message);
    }
}
