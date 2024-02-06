# 2daw-m07-geomir-backend-laravel10
Backend del projecte GeoMir de 2DAW. Curs 2023-2024.

Laravel 10 amb Debugbar, Breeze i Tailwind.
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

Preparar lo necesario para pasar a produccion:

    npm run build

# Git

 Descarga los cambios del repositorio remoto en la rama local especificada.

Descarga los cambios remotos a local:

    git pull origin branch

Envía cambios locales a remoto:

    git push origin branch

Recuerda que el composer no se encuentra aqui.


## Notes de la versió 0.1

Hi ha uns fitxers extra per desplegar al servidor extern amb entorn de producció:

* index.php: Redirigeix a laravel/public/index.php
* laravel/.htaccess: Redirigeix TOTES les peticions al directori public

## Notes de la versió 0.2

### Filament

Hi ha dues formes de tenir recursos relacionats amb Filament:

 * L'administració de Posts utilitza [Relation managers](https://filamentphp.com/docs/2.x/admin/resources/relation-managers)
 * L'administració de Places utilitza [Relations](https://filamentphp.com/docs/2.x/admin/resources/getting-started#relations)

L'administració de Posts no permet la creació de recursos i recursos relacionats alhora. En canvi, l'administració de Places sí que ho permet gràcies a la combinació de [Relations](https://filamentphp.com/docs/2.x/admin/resources/getting-started#relations) i el mètode `mutateFormDataBeforeCreate` (veure [Customizing data before saving](https://filamentphp.com/docs/2.x/admin/resources/creating-records#customizing-data-before-saving)).

### Policy

Hi ha diverses formes de restringir l'accés a un recurs amb [`Policy`](https://laravel.com/docs/10.x/authorization#creating-policies). En aquesta versió, veiem les següents:

 * Posts i Places utilitzen el helper `authorizeResource` pels mètodes CRUD (index, create, store, show, edit, update i destroy)
 * Posts utilitza el helper `authorize` pels mètodes like i unlike
 * Places utilitza el middleware `can` pels mètodes favorite i unfavorite
 * Totes les vistes utilitzen les directives `@can` o `@cannot`