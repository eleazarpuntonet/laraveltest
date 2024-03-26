

# Quotes App

## The application must have the following features

1. User authentication and profile update page
2. A separate composer package located in `./packages/quotes` that handles all quote-related functionality:
    1. A facade that fetches a number of random quotes from the API
    2. Implement rate limiting for API requests to prevent abuse. The API should be limited to 30 requests per minutes by default but should be customizable from the main application
    3. An API route should be registered in the package to fetch a specified number of random quotes
    4. An API route should be registered in the package to fetch your favorites quotes
    5. An API route should be registered in the package to delete a quote from your favorites
    6. All API routes should be customizable from the main application (prefix, middleware, etc.)
    7. Above features are to be tested with Feature tests inside the package
3. Separate admin authentication for moderating saved user quotes and banning users
4. Frontend should be done with Vue.js and optionally Inertia.js
    1. Typescript should be used for any frontend functionality
    1. UI should be responsive
5. All API route should be secured with an user token
6. Above features are to be tested with Feature tests

## Developer

Name: `Eleazar Ortega` <br/>
Email: `eleazar.sb18@gmail.com`<br/>

## Instructions

### Cloning the repository

1. Create a bare clone of the repository. (This is temporary and will be removed so just do it wherever.)

    ```bash
    git clone git@github.com:eleazarpuntonet/laraveltest.git
    ```

## Getting Started

1. Create a copy of the `.env.example` file as `.env`

    ```bash
    cp .env.example .env
    ```

2. Install dependencies:

<details>
<summary> Docker</summary>

3. Install composer dependecies

    ```shell
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs
    ```

4. Start the container (Sail):

    ```shell
    ./vendor/bin/sail up -d --build
    ```

5. Run migrations (Sail):

    ```shell
    ./vendor/bin/sail artisan migrate
    ```


6. Generate a new secret key:

    ```shell
    ./vendor/bin/sail artisan key:generate
    ```

7. Publish packages pages:

    ```shell
    ./vendor/bin/sail artisan vendor:publish --tag=quotes-views
    ```

8. Install frontend dependencies:

    ```shell
    npm install
    ```

9. Run frontend views:

    ```shell
    npm run dev
    ```

7. Publish packages config file:

    ```shell
    ./vendor/bin/sail artisan vendor:publish --tag=config
    ```

10. Go to http://localhost in your browser:
11. Go to http://localhost/api/login in your browser:
12. Go to http://localhost/api/quotes in your browser:
13. Go to http://localhost/api/favorites-quotes in your browser:



</details>


## Acceso a la Aplicación

Una vez que los contenedores Docker estén en funcionamiento y el frontend se haya compilado, la aplicación estará disponible en `http://localhost:80`.

## Registro e Inicio de Sesión

1. Accede a la aplicación a través de tu navegador web.

2. Completa el formulario de registro para crear una nueva cuenta.

3. Inicia sesión con tu nueva cuenta.

## Visualización de Quotes

Una vez que hayas iniciado sesión, podrás ver las quotes en la aplicación.

## Acceso a Favoritos

En el menú superior de la aplicación, encontrarás un botón para acceder a tus quotes favoritas. Aquí podrás ver las quotes que has marcado como favoritas.

## Realización de Requests a la API

Para realizar requests a la API de quotes, asegúrate de agregar el encabezado `Accept` con el valor `application/json`. Además, debes haber iniciado sesión previamente en la ruta `localhost/api/login` para obtener un token de acceso a las rutas API del proyecto. Cuando realices un request, agrega también el encabezado `Authorization` con el valor `Bearer <token_obtenido_en_api/login>`.


## Executing Commands

<details>
<summary>Docker/Sail</summary>

### PHP Commands

```shell
./vendor/bin/sail php --version
 
./vendor/bin/sail php script.php
```

### Composer Commands

```shell
./vendor/bin/sail composer require laravel/sanctum
```

### Artisan Commands

```shell
./vendor/bin/sail artisan queue:work
```

### Node / NPM Commands

```shell
./vendor/bin/sail node --version
 
./vendor/bin/sail npm run dev
```

If you wish, you may use Yarn instead of NPM:

```shell
./vendor/bin/sail yarn
```

### Running Tests

```shell
./vendor/bin/sail test

./vendor/bin/sail test --group orders
```

</details>

<details>
<summary>Without Docker</summary>

### Artisan Commands

```shell
php artisan serve
php artisan list
```

### Node / NPM Commands

```shell
npm run dev
// or
npm run build
```

### Running Tests

```shell
composer test
```

</details>
