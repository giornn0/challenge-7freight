## Setup

This guide is specific for Linux SO.

1. Clone this repository

```
git clone git@github.com:giornn0/challenge-7freight.git
```

Now choose between continuing the setup with docker or with native tools.

### Docker/Podman

Follow the list.

1. Copy the .env.example

```
cp .env.example .env
```

> Don't change anything inside this file

2. Build app image and setup the necessary containers:

```
podman-compose up -d
```

3. Get inside the app container:

```
podman exec -it challenge-app bash
```

4. Run database migrations and seeders:

```
php artisan migrate --seed
```

5. Exit the app container:

```
exit
```

> If you have docker, replace podman with docker, and podman-compose with docker-compose.

### Native

1. Make sure you have the next tools installed:

| Name     | Version |
| -------- | ------- |
| php      | > 8.2   |
| composer | > 2.7   |
| mysql    | 8.0     |

2. Copy the .env.example.local-sql:

```
cp .env.example.local-sql .env
```

> Inside this file, you need to put some **credentials for your mysql access**. Change **DB_USERNAME** and **DB_PASSWORD** accordingly

3. Install dependencies:

```
composer install
```

4. Run database migrations and seeders:

```
php artisan migrate --seed
```
4. Run application:

```
php artisan serve
```

## Explore
Check the next requests with their corresponding method:
#### GET [Available Classes](http://localhost:8000/api/classes/schedule).
- Response: { data: Array<{ nameClass: { start: Time, end: Time, classBlockId: int } }>}
#### POST [Book Class Block](http://localhost:8000/api/classes/book).
- Body: { sudentId: int, classBlockId: int}
#### DELETE [Booked Class](http://localhost:8000/api/classes/book).
- QUeryParameters: { sudentId: int, classBlockId: int}

We also provide an Insomnia json (challenge-insomnia-collection.json) for testing the endpoint.

## Possible Errors

-   In case of error with laravel.log file, regarding access to write file (mostly happens with docker) run:

```
chmod -R 777 storage
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
