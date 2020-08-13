
## Keyshare

![GitHub Workflow Status](https://img.shields.io/github/workflow/status/andy3471/keyshare/build%20our%20image)
![Docker Pulls](https://img.shields.io/docker/pulls/andy3471/keyshare)

Keyshare allows you to share any extra video game key codes that you have left over with your Game Groups.

Currently, keyshare can be self hosted for one group. Users can sign in with a local account, or sign in via steam. They can then add keys for games, which can then be claimed by other users

![ScreenShot](https://raw.github.com/andy3471/keyshare/master/docs/img/keyshare-gamelist.jpg)
[Try Out the Demo](https://keyshare.andyh.app)

## Technologies

Built on the Laravel PHP Framework, with Vue JS.

All development environments are running MySQL, Redis and Nginx. Laravel offers support for other DB and web servers, however these are untested.

## Install

We recommend installing Keyshare using Docker and Docker-compose. Please see the below example docker-compose file:

```yml
version: '3'
services:
  keyshare-web:
    image: andy3471/keyshare
    restart: unless-stopped
    container_name: keyshare-web
    ports:
     - "3472:80"
    environment:
     APP_NAME: KeyshareDemo
     APP_KEY: base64:Hsn2BwXdpKHhEiTSDkkuWP1OwbfcZZFQlLoWbjY4lk8=
     STEAM_LOGIN: false
     STEAM_API_KEY: 12345
     APP_URL: https://360nohope.co.uk
     ASSET_URL: https://360nohope.co.uk
     DB_HOST: keyshare-db
     DB_DATABASE: keyshare
     DB_USERNAME: keyshare
     DB_PASSWORD: secret
     REDIS_HOST: keyshare-redis
    AUTO_APPROVE_USERS: 0
    volumes:
      - ./web/logs:/app/storage/logs
      - ./web/app:/app/storage/app
    depends_on:
      - keyshare-db
      - keyshare-redis
  keyshare-db:
    image: mysql:5.7.30
    restart: unless-stopped
    container_name: keyshare-db
    environment:
     MYSQL_DATABASE: homestead
     MYSQL_USER: homestead
     MYSQL_PASSWORD: secret
     MYSQL_ROOT_PASSWORD: secret
  keyshare-redis:
    image: redis:6.0.4
    container_name: keyshare-redis
    restart: unless-stopped
    entrypoint: redis-server --appendonly yes
```

Once you have saved this docker-compose file, and run it, you should see the website on localhost:3472. Then register as a normal user, and run:

```sh
docker-compose exec keyshare-web php artisan admin:make your@email.com
```

Sign out and back in, and you should now be an admin.

### Configuration

The below are all the environment variables that can be passed to the docker-compose file:

Variable | Description
------------ | -------------
APP_NAME | Title of the website
APP_ENV | Environment being run on, can be set to local for test environments
APP_KEY | Unique base64 string. Run docker run -e "CONTAINER_ROLE=keygen" andy3471/keyshare to generator one, and paste it in.
APP_DEBUG | Enables debug logging
APP_URL | External URL you will access the site from
ASSET_URL | External URL that assets are loaded from
AUTO_APPROVE_USERS | Boolean value, Whether anyone can sign up for the site, or they require an admin to authorise them
REDIRECT_HTTPS | Boolean value, Used if you're running keyshare behind a proxy, if the site is using HTTP and the proxy is using HTTPS.
STEAM_LOGIN | Boolean value, enabled steam login
STEAM_API_KEY | API key for steam login, generated on https://steamcommunity.com/dev/apikey
DB_HOST | MySQL host, usually the container name of the SQL server
DB_PORT | Defaults to 3306, only override if you're using your own DB server
DB_DATABASE | Name of the database
DB_USERNAME | Username for the DB
DB_PASSWORD | Password for the DB user
REDIS_HOST | Hostname of the redis container
REDIS_PASSWORD | Only use if you're using a password protected redis instance
REDIS_PORT | Port of redis, defualts to 6379, so don't change it unless you're running your own redis instance on a different port
MAIL_HOST | SMTP host
MAIL_PORT | SMTP Port
MAIL_USERNAME | Email Username
MAIL_PASSWORD | Email Pasword
MAIL_ENCRYPTION | can be set to SSL or TLS, if your mail server requires it.
MAIL_FROM_NAME | Name that emails appear to be sent from.

You can override the logo by adding the following volume bind, and creating a file called logo.png locally, in the docker-compose folder.:
```yml
- ./logo.png:/app/public/images/logo_override.png
```

Karma is calculated and stored in redis, if you ever have desync issues, you can run the following to recalculate it:

```sh
docker-compose exec keyshare-web php artisan karma:generate
```

### Reverse Proxy
You can run the site behind an NGINX reverse proxy, using a config like:
```conf
server {
    server_name 360nohope.co.uk www.360nohope.co.uk;

    location / {
        proxy_pass http://ip:port;
        proxy_set_header Host 360nohope.co.uk
        proxy_set_header X-Forwarded-Proto https;
    }
}
```

If your proxy erver is using HTTPS, be sure to set the REDIRECT_HTTPS environment variable to true. You will also need to set APP_URL to the external URL, and may also need to set ASSET_URL to the same.

### Manual Install

[Manual Install Guide](docs/INSTALL.md)  
[Configuration](docs/CONFIG.md)

## Contributing

[Setting up a dev environment](docs/DEVENVIRONMENT.md)  
[Debugging](docs/DEBUG.md)  
[Contribution guidelines](docs/CONTRIBUTING.md)
