bin/bash
set -e


#borramos todas las tablas y creamos 
php artisan migrate:fresh

# # # # #corremos las migraciones
php artisan db:seed

# # # # # #generamos las claves para autenticarse
php artisan passport:install