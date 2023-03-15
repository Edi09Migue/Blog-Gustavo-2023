<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Infomar\Especies;
use App\Models\Cms\Pagina;
use App\Models\Cms\Slider;
use App\Models\Configuracion;
use App\Models\Infomar\Categoria;
use App\Models\Infomar\Especie;
use App\Models\Infomar\Ingrediente;
use App\Models\Infomar\Receta;
use App\Models\Infomar\TipoReceta;

class HomeCtrl extends Controller
{
    var $data;


    public function __construct()
    {
        // $this->data['facebook_url'] = Configuracion::valor('facebook_url');
        // $this->data['instagram_url'] = Configuracion::valor('instagram_url');
        // $this->data['twitter_url'] = Configuracion::valor('twitter_url');
        // $this->data['configsContacto'] =collect([
        //     'contacto_nuevo' => Configuracion::valor('contacto_nuevo'),
        //     'contacto_mensaje_final' => Configuracion::valor('contacto_mensaje_final'),
        // ]);
        // $this->data['infoEmpresa'] = collect([
        //     'nombre_empresa' => Configuracion::valor('company_name'),
        //     'telefono' => Configuracion::valor('telefono'),
        //     'email' => Configuracion::valor('email'),
        //     'direccion' => Configuracion::valor('direccion'),
        //     'slogan' => Configuracion::valor('slogan'),
            
        // ]);
        // $this->data['configsSuscribirse'] = collect( [
        //     'suscribirse_texto_general'=> Configuracion::valor('suscribirse_texto_general'),
        //     'suscribirse_texto_descriptivo' => Configuracion::valor('suscribirse_texto_descriptivo'),
        //     'suscribirse_texto_final' => Configuracion::valor('suscribirse_texto_final'),
        // ]);

        
    }
    


    /**
     * Página de home
    */
    public function home(){    
        $articulos = Pagina::where('estado', 'publicada')->get();
        $this->data['articulos'] = $articulos;
        return view('front.home', $this->data);
    }

     /**
     * Página de receta
    */
    public function articulo($articulo){

        $articulo = Pagina::where('slug',$articulo)->first();

        $otros_articulos = Pagina::where('id','!=', $articulo->id)->where('estado', 'publicada')->get()->take(3);
        $this->data['otros_articulos'] = $otros_articulos;

        if($articulo){
            $this->data['articulo'] = $articulo;
            return view('front.articulo', $this->data);
        }else{
            return view('front.pages.no_encontrada');
        }       
   
    }





    
 
}
