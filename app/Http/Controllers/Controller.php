<?php

namespace App\Http\Controllers;

use App\Dtos\Result;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use JetBrains\PhpStorm\NoReturn;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * echo
     */
    protected function echo(string $key): string {
        return $key;
    }

    /**
     * ok
     */
    protected function ok(Result $result): SuccessResponse
    {
        return new SuccessResponse($result);
    }

    /**
     * error
     */
    #[NoReturn] protected function error(string $message, int $status = 400): ErrorResponse
    {
        return new ErrorResponse($message, $status);

    }
}
