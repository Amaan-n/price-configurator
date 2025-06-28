# Price Configurator App with Dynamic Discounts

A Laravel 12 + Livewire web app to dynamically calculate product prices based on attributes and discount rules.

## Features
- Select multiple products
- Choose size, color, and material
- Switch user type (normal / company)
- Real-time price breakdown
- Discounts: attribute-based, total-based, user-type based

## Tech Stack
- Laravel 12
- Livewire
- Tailwind CSS
- Vite

## Setup

```bash
git clone https://github.com/yourusername/price-configurator.git
cd price-configurator
composer install
cp .env.example .env
php artisan key:generate

# Configure your DB in .env then:
php artisan migrate --seed

npm install && npm run dev
php artisan serve
