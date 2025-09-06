<?php
namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Log;

class TwitterService
 {
    protected $apiKey;
    protected $apiSecret;
    protected $accessToken;
    protected $accessSecret;

    public function __construct()
 {
        // $this->apiKey = env( 'TWITTER_API_KEY' );
        // $this->apiSecret = env( 'TWITTER_API_SECRET' );
        // $this->accessToken = env( 'TWITTER_ACCESS_TOKEN' );
        // $this->accessSecret = env( 'TWITTER_ACCESS_SECRET' );
        $this->apiKey = 'X1wViljXufXkbYt1BcsPu08ZX';
        $this->apiSecret = 'ZqhyqUFQ3jiqNvi752l1hXtWdvciSN69ekhfYANQMgFwg3c2WS';
        $this->accessToken = '1962794287227379717-SnuF5HNp1tec1hCTrofiRngjRk68Ea';
        $this->accessSecret = 'P3dmO7YnXpTHTUtRAPmKRs2Dlf2UkjItVnJzVWazvS3I7';
        

    }

    public function post( string $text ): array
 {
       try {
        $connection = new TwitterOAuth(
            $this->apiKey,
            $this->apiSecret,
            $this->accessToken,
            $this->accessSecret
        );

        // Force API v2 endpoint
        $connection->setApiVersion('2');

        $result = $connection->post('tweets', ['text' => $text], ['json' => true]);
        $httpCode = $connection->getLastHttpCode();

        $resultArr = $result ? json_decode(json_encode($result), true) : [];

        Log::info('Twitter raw response', [
            'http_code' => $httpCode,
            'result' => $resultArr
        ]);

        if ($httpCode !== 201) { 
            Log::error('Twitter post failed', [
                'http_code' => $httpCode,
                'result' => $resultArr
            ]);
        }

        return $resultArr;
    } catch (Exception $e) {
        Log::error('Twitter post exception', ['message' => $e->getMessage()]);
        return ['error' => $e->getMessage()];
    }
}
    
}