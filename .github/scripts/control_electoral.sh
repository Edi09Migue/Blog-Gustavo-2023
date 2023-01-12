bin/bash
set -e


#borramos todas las tablas y creamos 
php artisan migrate:fresh

# # # # #corremos las migraciones
php artisan db:seed


#Correr migraciones de control_electoral
php artisan migrate --path=database/migrations/control-electoral

# # # # # #generamos las claves para autenticarse
php artisan passport:install