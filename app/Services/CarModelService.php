<?php


namespace App\Services;


use App\Dtos\Result;
use App\Models\Cart;
use App\Models\CartService;
use App\Models\User;
use Exception;
use GuzzleHttp\Promise\Tests\Thing1;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class CarModelService extends Service
{
    protected string $baseUrl = 'https://carapi.app/api/';

    /**
     * @throws ConnectionException
     */
    public function login($apiToken, $apiSecret)
    {
        $url = $this->baseUrl . 'auth/login';

        $response = Http::withHeaders([
            'accept' => 'text/plain',
            'Content-Type' => 'application/json',
        ])->post($url, [
            'api_token' => $apiToken,
            'api_secret' => $apiSecret,
        ]);

        return $response->json();
    }

}
