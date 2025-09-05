<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->baseUrl = "https://api.telegram.org/bot{$this->token}/";
    }

    public function setWebhook(string $url)
    {
        return Http::get($this->baseUrl . 'setWebhook', ['url' => $url])->throw(false)->json();
    }

    public function getUpdates()
    {
        return Http::get($this->baseUrl . 'getUpdates')->throw(false)->json();
    }

    public function sendMessage($chatId, $text)
    {
        return Http::post($this->baseUrl . 'sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
        ])->throw(false)->json();
    }
}
