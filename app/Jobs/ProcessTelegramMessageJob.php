<?php

namespace App\Jobs;
use App\Models\TelegramMessage;
use App\Services\OpenAIService;
use App\Services\TwitterService;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTelegramMessageJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct( public TelegramMessage $message ) {
    
    }

    public function handle( OpenAIService $ai, TwitterService $x ): void {
        $message = TelegramMessage::find( $this->message->id );

        if ( !$message || $message->posted_to_x ) return;

        $src = $message->message_text ?? '';
        if ( $src === '' ) return;

        $rewritten = $ai->rewriteText( $src );
        $message->rewritten_text = $rewritten;
        $message->save();

        $resp = $x->post( $rewritten );

        $tweetId = $resp['id_str'] ?? $resp['id'] ?? $resp['data']['id'] ?? null;
        // echo $tweetId; exit;

        if ($tweetId) {
            $message->update( [
                'posted_to_x' => true,
                'posted_at'   => now(),
                'tweet_id' => $tweetId,
            ] );
        } else {
            Log::warning('Tweet not confirmed', [ 
            'resp' => $resp, 
            'msg' => $message->id 
            ] );
        }

    }
}

