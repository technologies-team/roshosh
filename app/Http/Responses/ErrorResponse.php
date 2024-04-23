<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

/**
 * error response
 */
class ErrorResponse extends JsonResponse
{
    /**
     *
     * @param string $message
     * @param mixed $statusCode
     */
    public function __construct(string $message = '', int $statusCode= -1 )
    {
        $data = [];
        $data['message'] = $message;
        $data['statusCode'] = $statusCode;
        parent::__construct($data, 400);
    }
}
