# CORE SANTANA eCORP

## About CORE

## Aditional laravel packages

-   [Audit tools](http://www.laravel-auditing.com/). Audit tools package documentation
-   [Excel tools](https://laravel-excel.com/). Excel tools package documentation
-   [Laravel websockets](https://beyondco.de/docs/laravel-websockets). 
-   [Laravel Permissions](https://spatie.be/docs/laravel-permission/). Permission manager documentation

-   [Vuexy Template](https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/documentation/guide/laravel-integration/installation.html). Front-End template documentation

-   [DBML](https://www.dbml.org/docs/) Database Markup Language Documentation
-   [Database Dictionary](https://dbdocs.io/dexterx17/core) Database Diagrama and Documentation

-   [PHPUNIT](https://phpunit.readthedocs.io/es/latest/) Pruebas unitarias y de cobertura

## Deploy

```
php artisan migrate --seed
```

```
php artisan passport:install
```

```
php artisan websockets:serve 
```

## Testing

Lineamientos para escribir pruebas  ttps://github.com/framgia/laravel-test-guideline

Para ejecutar todas las pruebas 
 ```php artisan test ```

Para generar el reporte de Code Coverage necesitamos habilitar xdebug

 ```./vendor/bin/phpunit --coverage-html reports ```

Para habilitar xdebug debemos agregar al final de php.ini lo siguiente

zend_extension = php_xdebug.dll
xdebug.remote_enable = 1
xdebug.remote_handler = dbgp
xdebug.remote_host = localhost
xdebug.remote_autostart = 1
xdebug.remote_port = 9000
xdebug.show_local_vars = 1

## Features

- Módulo de Seguridad
- - [ ] Iniciar sesión 
- - [ ] Recuperar contraseña
- - [ ] Perfil de usuario
- - [ ] CRUD Usuarios
- - [ ] CRUD Roles
- - [ ] CRUD Permisos
- - [ ] Configuraciones Generales
- - - [ ] Notificaciones
- - - [ ] Datos del sistema
- - [ ] Registrar Usuarios


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
