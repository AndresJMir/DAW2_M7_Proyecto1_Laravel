# 2daw-m07-geomir-backend-laravel10
Backend del projecte GeoMir de 2DAW. Curs 2023-2024.

Laravel 10 amb Debugbar, Breeze i Tailwind.

Fitxers extra:

* index.php: Redirigeix a laravel/public/index.php
* laravel/.htaccess: Redirigeix TOTES les peticions al directori public

# Desplegar

Instalacion de dependencias del proyecto:

    composer install

Preparar el .env

    cp .env.example .env
    nano .env

Generacion de llaves:

    php artisan key:generate 

Permisos para permitir la visualizacion de las imagenes

    php artisan storage:link

Migracion y seeders:

    php artisan migrate:fresh
    php artisan db:seed

**Recuerda** configurar el modo de desarrollo en .env

Preprarar Vite

    npm install

Activar el servidor usado en debug (recuerda tener el modo debug en .env), recuerda tenerlo en dos terminales separadas simultaneamente:

    npm run dev
    php artisan serve

# Git

 Descarga los cambios del repositorio remoto en la rama local especificada.

Descarga los cambios remotos a local:

    git pull origin branch

Envía cambios locales a remoto:

    git push origin branch
