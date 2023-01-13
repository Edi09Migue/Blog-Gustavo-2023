bin/bash
set -e


#borramos todas las tablas y creamos 
php artisan migrate:fresh

#Correr migraciones de control_electoral
php artisan migrate --path=database/migrations/control-electoral

# # # # #corremos las migraciones
php artisan db:seed

# # # # # #generamos las claves para autenticarse
php artisan passport:install