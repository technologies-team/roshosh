<?php

namespace App\DTOs;

class Result
{
    /**
     *
     */
    public int $statusCode;

    /**
     *
     */
    public string $message;

    /**
     *
     */
    public mixed $data;

    public function __construct( $data, string $message = '', int $statusCode = 0)
    {
        $this->data = $data;
        $this->message = $message;
        $this->statusCode = $statusCode;
    }
}
