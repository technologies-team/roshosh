<?php


namespace App\Services;


use App\Dtos\Result;
use App\Dtos\SearchQuery;
use App\Models\Cart;
use App\Models\CartService;
use App\Models\User;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\Tests\Thing1;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use function Webmozart\Assert\Tests\StaticAnalysis\object;

class CarModelService extends Service
{
    protected string $baseUrl = 'https://car-api2.p.rapidapi.com';
    protected string $apiKey = "28c02d99admsh9123df11a020de1p1f44f9jsn925f19d2d033";
    protected string $host = "car-api2.p.rapidapi.com";

    /**
     * @throws GuzzleException
     */
    public function make(): array
    {
        $client = new \GuzzleHttp\Client();
        $route="/api/makes?direction=asc";
        $response = $client->request('GET', $this->baseUrl.$route, [
            'headers' => [
                'X-RapidAPI-Host' => $this->host,
                'X-RapidAPI-Key' => $this->apiKey,
            ],

        ]);
        $responseData = $response->getBody();
        $responseData = json_decode($responseData, true);;
        $models = array();

        if (isset($responseData['data'])) {
            foreach ($responseData['data'] as $key => $make) {
                $models[$key]['id'] = $make['id'] ?? "0";
                $models[$key]['name'] = $make['name'] ?? "";
            }
        }
        return ($models);
    }

    /**
     * @throws GuzzleException
     */
    public function search(SearchQuery $q): array
    {
        return $this->make();
    }


}
