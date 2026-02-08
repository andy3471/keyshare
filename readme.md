# Sparekey.club

Share your spare game keys with friends. Create groups, add your leftover keys from bundles, and let friends claim the games they want.

## About

Sparekey.club is built with [Laravel](https://laravel.com), [Vue.js](https://vuejs.org), and [Inertia.js](https://inertiajs.com). It uses [Tailwind CSS](https://tailwindcss.com) for styling and [Laravel Sail](https://laravel.com/docs/sail) for local development.

## Installation

This is a standard Laravel application. Follow the official Laravel documentation for installation and deployment:

- [Installation](https://laravel.com/docs/installation)
- [Configuration](https://laravel.com/docs/configuration)
- [Deployment](https://laravel.com/docs/deployment)

### Quick Start (Local Development)

```bash
# Clone the repo
git clone https://github.com/andy3471/sparekey.club.git
cd sparekey.club

# Install PHP dependencies
composer install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Start Sail
vendor/bin/sail up -d

# Install JS dependencies and build assets
vendor/bin/sail npm install
vendor/bin/sail npm run build

# Run migrations
vendor/bin/sail artisan migrate
```

## Contributing

Pull requests are welcome. For local development, use [Laravel Sail](https://laravel.com/docs/sail) to run the application.

## Support

If you find this project useful, consider supporting development:

- [Ko-fi](https://ko-fi.com/andy3471)
- [GitHub](https://github.com/andy3471/sparekey.club)
