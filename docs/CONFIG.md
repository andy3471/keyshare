# Configuration

## About

All system settings are stored in the .env file, this guide will go through any of the settings, and explain how they are configured.

Please keep in mind that settings are cached, and any time you update them, you should update the cache:  
`php artisan optimize`

## Config

### APP_NAME

The name of the site, can be any string. Should be in single quotes if there is a space in it.

### APP_ENV

Should not change, laravel default setting.

### APP_KEY

Generated using  
`php artisan key:generate`

Should not be changed manually, but must not be null.

### APP_DEBUG

Enhanced debugging. Recommended to be false for live environments.

### APP_URL

The full URL of the site, for example https://360nohope.co.uk

### APP_DEMO_MODE

Enabled demo mode, which does a nightly data refresh. This should almost always be false.

### AUTO_APPROVE_USERS

A boolean value, this controls if users need approval to sign in, we recommend setting to 0.

### LOG_CHANNEL

Configures how keyshare logs it's config. Can be configured to any [laravel supported logging driver](https://laravel.com/docs/6.x/logging)

### CACHE_STORE

This should always be Redis. We recommend installing redis in our install guide.

### QUEUE_CONNECTION=redis

Not currently in use

### BROADCAST_CONNECTION

Not currently in use

### SESSION_DRIVER

How sessions will be stored, we support all [laravel supported session drivers](https://laravel.com/docs/6.x/session). Redis is recommended.

### SESSION_LIFETIME

How long sessions last, recommended is 120 minutes.

### TELESCOPE_ENABLED

Enables laravel telescope, should be false for Live.

## Steam

This feature allows the "Sign In With Steam" button to show on the login screen. This requires an API key with steam to be genreated.

### STEAM_LOGIN

This enables steam login.

### STEAM_KEY

You need to generate a [steam api key](https://steamcommunity.com/dev/apikey) and insert the key here.

### STEAM_SECRET

The same as the Steam Key.

### STEAM_REDIRECT_URI

This is the URL the site redirects to. it should be the full site name, with /login/steam/callback on the end. For example:  
`STEAM_REDIRECT_URI=https://360nohope.co.uk/login/steam/callback`

## Database Connections

We support any [laravel supported DB driver](https://laravel.com/docs/6.x/database). We recommend MySQL.

### DB_CONNECTION

Driver Name, as in the above laravel guide.

### DB_HOST

DB Server Name

### DB_PORT

DB Port

### DB_DATABASE

Database Name

### DB_USERNAME

Database username

### DB_PASSWORD

Database password

## Redis

This will not need changing if you have installed locally, but you will need to update the following strings if you are hosting redis elsewhere:

### REDIS_HOST

Hostname of redis server

### REDIS_PASSWORD

Redis server password, if configured

### REDIS_PORT

Port for redis

## Email

In order to use password resets, you should set up an SMTP server, the following details should be provided from your email provider. You can set up [Gmail](https://stackoverflow.com/questions/32515245/how-to-to-send-mail-using-gmail-in-laravel-5-1)

### MAIL_DRIVER

Should always be SMTP for live

### MAIL_HOST

Provided by your SMTP provider

### MAIL_PORT

Provided by your SMTP provider

### MAIL_USERNAME

Provided by your SMTP provider

### MAIL_PASSWORD

Provided by your SMTP provider

### MAIL_ENCRYPTION

Provided by your SMTP provider

### MAIL_FROM_NAME

The name of the sender when emails are received (Normally the site name)
