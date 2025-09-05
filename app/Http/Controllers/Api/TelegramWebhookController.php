<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTelegramMessageJob;
use App\Models\TelegramMessage;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        // Webhook OR getUpdates style payload both supported:
        $updates = $payload['result'] ?? [$payload];

        foreach ($updates as $update) {
            $post = $update['channel_post'] ?? $update['message'] ?? null;
            if (!$post) continue;

            $entity = TelegramMessage::updateOrCreate(
                ['update_id' => $update['update_id'] ?? ($post['message_id'] ?? null)],
                [
                    'message_id'   => $post['message_id'] ?? 0,
                    'chat_id'      => $post['chat']['id'] ?? 0,
                    'chat_title'   => $post['chat']['title'] ?? null,
                    'message_text' => $post['text'] ?? ($post['caption'] ?? null),
                    'message_date' => isset($post['date']) ? now()->setTimestamp($post['date']) : null,
                    'raw_update'   => $update,
                ]
            );

            // Only process if from your channel (optional guard)
            if ((int)$entity->chat_id === (int)env('TELEGRAM_CHANNEL_ID')) {
                \Log::info('Dispatching job for TelegramMessage ID: ' . $entity->id);
                ProcessTelegramMessageJob::dispatch($entity);
            }
        }

        return response()->json(['ok' => true]);
    }
}
