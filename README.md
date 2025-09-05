# laravel-telegram-twitter-bot
# Telegram → AI → Twitter Automation (Laravel)

## Features
- Fetches messages from a private Telegram channel
- Uses OpenAI API to rewrite text
- Posts rewritten text to Twitter (X) automatically
- Laravel Queue Jobs for async processing

## Setup
1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/telegram-to-twitter.git
   cd telegram-to-twitter
   
2. Install dependencies
   composer install
   npm install && npm run build
   
3. Copy .env file and configure your environment
   cp .env.example .env
   php artisan key:generate

   Update the following keys in .env:
   TELEGRAM_BOT_TOKEN=your_telegram_bot_token
   TELEGRAM_CHANNEL_ID=your_channel_id
   OPENAI_API_KEY=your_openai_api_key
   
   TWITTER_API_KEY=your_api_key
   TWITTER_API_SECRET=your_api_secret
   TWITTER_ACCESS_TOKEN=your_access_token
   TWITTER_ACCESS_SECRET=your_access_secret
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=telegram_twitter
   DB_USERNAME=root
   DB_PASSWORD=
   
4. Run migrations
   php artisan migrate

5. Start local server
   php artisan serve

6. Run queue worker
   php artisan queue:work

API Endpoint
Webhook URL (Telegram → Laravel):
POST http://127.0.0.1:8000/api/telegram/webhook

Tech Stack
Laravel 10
Telegram Bot API
OpenAI GPT API
Twitter API (OAuth 1.0a)
MySQL
