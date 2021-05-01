<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Seeder;

class ConfiguracionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Configuraciones Generales
        $config = new Configuracion();
        $config->key = "logo";
        $config->value = "logo_local.png";
        $config->tipo = "image";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "company_name";
        $config->value = "SANTANA eCorp";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "company_shortname";
        $config->value = "SANTANA";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "slogan";
        $config->value = "Soluciones innovadoras a tu medida";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "ruc";
        $config->value = "1600392359001";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "facebook_url";
        $config->value = "https://www.facebook.com";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "instagram_url";
        $config->value = "https://www.instagram.com";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "twitter_url";
        $config->value = "https://www.instagram.com";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "email";
        $config->value = "sistemas@santana.ec";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "telefono";
        $config->value = "(03) 2830-032  Ext. 101";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "fax";
        $config->value = "(03) 2830-032  Ext. 101";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        $config = new Configuracion();
        $config->key = "direccion";
        $config->value = "Av. Confraternidad y Av.22 de Julio";
        $config->tipo = "string";
        $config->group_key = "general";
        $config->save();

        //Configuraciones Sistema
        $config = new Configuracion();
        $config->key = "iva";
        $config->value = "12";
        $config->tipo = "double";
        $config->group_key = "sistema";
        $config->save();

        $config = new Configuracion();
        $config->key = "decimales";
        $config->value = "4";
        $config->tipo = "int";
        $config->group_key = "sistema";
        $config->save();

        $config = new Configuracion();
        $config->key = "formato_fecha";
        $config->value = "l, d M Y - H:m";
        $config->tipo = "string";
        $config->group_key = "sistema";
        $config->save();

        $config = new Configuracion();
        $config->key = "idioma";
        $config->value = "spanish";
        $config->tipo = "string";
        $config->group_key = "sistema";
        $config->save();

        $config = new Configuracion();
        $config->key = "en_mantenimiento";
        $config->value = "0";
        $config->tipo = "bool";
        $config->group_key = "sistema";
        $config->save();

        //Configuraciones SMTP
        $config = new Configuracion();
        $config->key = "servidor_smtp";
        $config->value = "smtp.googlemail.com";
        $config->tipo = "string";
        $config->group_key = "correo";
        $config->save();

        $config = new Configuracion();
        $config->key = "user_smtp";
        $config->value = "jagusy@gmail.com";
        $config->tipo = "string";
        $config->group_key = "correo";
        $config->save();
        
        $config = new Configuracion();
        $config->key = "password_smtp";
        $config->value = "123456";
        $config->tipo = "string";
        $config->group_key = "correo";
        $config->save();
        
        $config = new Configuracion();
        $config->key = "puerto_smtp";
        $config->value = "465";
        $config->tipo = "int";
        $config->group_key = "correo";
        $config->save();
        
        $config = new Configuracion();
        $config->key = "encryption_smtp";
        $config->value = "ssl";
        $config->tipo = "string";
        $config->group_key = "correo";
        $config->save();

        //Notificaciones
        $config = new Configuracion();
        $config->key = "notificaciones_mail";
        $config->value = "0";
        $config->tipo = "bool";
        $config->group_key = "notificaciones";
        $config->save();

    }
}
