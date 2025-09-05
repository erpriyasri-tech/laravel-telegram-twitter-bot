# laravel-telegram-twitter-bot
# Telegram → AI → Twitter Automation (Laravel)

## Features
- Fetches messages from a private Telegram channel
- Uses OpenAI API to rewrite text
- Posts rewritten text to Twitter (X) automatically
- Laravel Queue Jobs for async processing

## Setup
1. Clone repo
2. Run `composer install && npm install`
3. Copy `.env.example` → `.env` and set:
   - `TELEGRAM_BOT_TOKEN`
   - `TELEGRAM_CHANNEL_ID`
   - `OPENAI_API_KEY`
   - `TWITTER_API_KEY`, `TWITTER_API_SECRET`, `TWITTER_ACCESS_TOKEN`, `TWITTER_ACCESS_SECRET`
4. Run migrations:
   ```bash
   php artisan migrate
