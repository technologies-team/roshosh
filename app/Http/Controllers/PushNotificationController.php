<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Lcobucci\JWT\Exception;

class PushNotificationController extends Controller
{
    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function sendPushNotification(): JsonResponse
    {
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/../../../storage/app/firebase-auth.json');

        $messaging = $firebase->createMessaging();

        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => 'roshosh ',
                'body' => 'done'
            ],
            'topic' => 'allDevices',
            'to'=>"eDhStkEBf0JFmtuXjKY2Mf:APA91bGgKWQBwCFOkogh4V3FniDIE_SDX5tmZY8vrEZAtsEnDs44SlbH5f8TlCm7djBHTBBcmjoPzq1mZaoUBibi-GNFsEkcfDmTEBo73a3q5NwCnYFVoHckg_ftuMVIUqX2XN0UdeyU"
        ]);

        try {
            $messaging->send($message);
        }  catch (Exception $e){
            dd($e->getMessage());
        }

        return response()->json(['message' => 'Push notification sent successfully']);
    }
}
