<?php

namespace App\Helpers;

use Exception;

class Helpers
{
    /**
     * send_push_notif_to_device
     * @throws Exception
     */

    public static function send_push_notify_to_device($fcm_token, $data): mixed
    {
        $key = env('PUSH_NOTIFICATION_KEY');
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = array("authorization: key=" . $key,
            "content-type: application/json"
        );

        $request = [];
        $request['to'] = $fcm_token;
        $request["data"] = [
            "title" => $data['title'],
            "body" => $data['description'],
            "image" => $data['image'],
            "is_read" => "0",
        ];

        $request["notification"] = [
            "title" => $data['title'],
            "body" => $data['description'],
            "image" => $data['image'],
            "is_read" => "0",
            "icon" => "new",
            "sound" => "default",
        ];

        return Curl::make($url, "POST", $request, $header);
    }
}
