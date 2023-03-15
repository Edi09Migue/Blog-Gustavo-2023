#!/bin/bash
set -e


#borramos todas las tablas y creamos 
php artisan migrate:fresh

#Correr migraciones de cms
php artisan migrate --path=database/migrations/cms

#Correr migraciones de web
php artisan migrate --path=database/migrations/web

# # # # #corremos las migraciones
php artisan db:seed

# # # # # #generamos las claves para autenticarse
php artisan passport:install

# php artisan db:seed --class="Database\Seeders\ControlElectoral\CandidatoActaSeeder"