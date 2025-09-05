<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class OpenAIService
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->model = env('OPENAI_MODEL', 'gpt-4o-mini');
    }

    /**
     * Rewrites the given text using OpenAI chat completion.
    **/
    public function rewriteText(string $text): string
    {
        if (empty($this->apiKey)) {
            return $this->fallbackRewrite($text);
        }

        $system = "You are a helpful assistant that rewrites Telegram channel posts into concise, engaging tweets (X). Keep within 280 characters where possible and preserve meaning.";

        $response = Http::withToken($this->apiKey)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => $text],
                ],
                'max_tokens' => 150,
                'temperature' => 0.7,
            ]);

        if ($response->failed()) {
          
            \Log::error('OpenAI failed', ['status' => $response->status(), 'body' => $response->body()]);
            return $this->fallbackRewrite($text);
        }

        $json = $response->json();
       
        return $json['choices'][0]['message']['content'] ?? $this->fallbackRewrite($text);
    }

    protected function fallbackRewrite(string $text): string
    {
        // very simple fallback rewrite: trim, cut to 270 chars
        $t = trim(preg_replace('/\s+/', ' ', strip_tags($text)));
        if (mb_strlen($t) > 270) {
            return mb_substr($t, 0, 267) . '...';
        }
        return $t;
    }
}
?>