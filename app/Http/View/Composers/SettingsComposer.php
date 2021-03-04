<?php

namespace App\Http\View\Composers;

use App\Models\Configuracion;
use Illuminate\View\View;

class SettingsComposer
{

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $settings = [
            'company_name' => Configuracion::valor('company_name'),
            'company_shortname' => Configuracion::valor('company_shortname'),
            'slogan' => Configuracion::valor('slogan'),
            'logo' => Configuracion::valor('logo'),
            'logoURL' => Configuracion::where('key','logo')->first()->imageUrl,
            'telefono' => Configuracion::valor('telefono'),
            'email' => Configuracion::valor('email'),
            'direccion' => Configuracion::valor('direccion'),
            'facebook_url' => Configuracion::valor('facebook_url'),
            'instagram_url' => Configuracion::valor('instagram_url'),
            'twitter_url' => Configuracion::valor('twitter_url'),
        ];
        
        $view->with($settings);
    }
}