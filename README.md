## Setup

This guide is specific for linux SO.

1. Copy the .env.example.

```
cp .env.example .env
```

### Docker/Podman

Follow the list.

1. Build app image and setup the necessary containers:

```
podman-compose up -d
```

2. Run database migrations and seeders:

```
podman exec -it challenge-app bash && php artisan migrate --seed && exit
```

> If you have docker, replace podman with docker, and podman-compose with docker-compose.

### Native

1. Make sure you have the next tools installed:

| Name     | Version |
| -------- | ------- |
| php      | > 8.2   |
| composer | > 2.7   |
| mysql    | 8.0     |

2. Install dependencies:

```
composer install
```

3. Run database migrations and seeders:

```
php artisan migrate --seed
```

## Explore

For testing the endpoints with Insomnia use the provided challenge-insomnia-collection.json

## Possible Errors

-   In case of error with laravel.log file, regarding access to write file (mostly happens with docker) run:

```
chmod -R 777 storage
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
