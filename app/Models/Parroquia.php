<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Optix\Media\HasMedia;

use Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Parroquia extends Model
{
    use HasMedia, HasSlug;
    
    protected $table = "parroquias";

    protected $fillable = [
        'gid0',//pais
        'gid1',//provincia
        'gid2',//canton
        'gid3',//parroquia
        'nombre',
        'nombre_corto',
        'slogan',
        'descripcion',
        'tipo',
        'slug',
        'engtype',
        'descripcion',
        'zipcode',
        'imagen',
        'icono',
        'estado',
        'orden',
        'bandera_url',
        'escudo_url',

        'minx',
        'miny',
        'maxx',
        'maxy',
        'lat',
        'lng',
        'zoom',
        'pitch',
        'bearing',
        
    ];

    public $timestamps = false;

    
    protected $appends = [
        'URL',
        'imagenURL',
        'iconoURL',
        'codigo'
    ];

    
     /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nombre')
            ->saveSlugsTo('slug');
    }
    
    /**
     * Cantón al que pertenece la parroquía
     */
    public function canton(){
        return $this->belongsTo(Canton::class,'gid2','gid2');
    }
    
    /**
     * Cantón al que pertenece la parroquía
     */
    public function provincia(){
        return $this->canton->provincia;
    }

    /**
     * En una parroquia hay varios lugares
     */
    public function lugares(){
        return $this->hasMany(Lugar::class);
    }

    /**
     * Devuelve los lugares visitados por el usuario logeado en esta parroquia
     */
    public function visitados(){
        
        $user_id = Auth::check() ? Auth::user()->id : 0;        

        return $this->lugares()->whereIn('id',function($sq) use($user_id) {
            $sq->select('lugar_id')->from('lugar_user')->where('user_id',$user_id);
        });
    }

    /**
     * Devuelve solo los lugares de tipo destino
     */
    public function scopeDestinos($query){
        return $this->lugares()->where('tipo','atractivo');
    }

    /**
     * Devuelve los destinos destacados de esta parroquia
     */
    public function scopeDestacados($query){
        return $this->lugares()->where('destacado',TRUE);
    }

    /**
     * Devuelve solo los lugares de tipo prestador
     */
    public function scopePrestadores($query){
        return $this->lugares()->where('tipo','prestador');
    }

    /**
     * En una parroquia se pueden realizar varias actividades, 
     * dependiendo de las actividades de los atractivos que lo conforman
     */
    public function scopeActividades(){
        $parroquia_id = $this->id;

        return Actividad::whereIn('id',function($sq) use($parroquia_id){
            $sq->select('actividad_id');
            $sq->from('actividad_lugar');
            $sq->whereIn('lugar_id',function($sq) use($parroquia_id){
                $sq->select('id');
                $sq->from('lugares');
                $sq->where('parroquia_id',$parroquia_id);
            });
        });
    }

    /**
     * En una parroquia puede tener varios subtipos, 
     * dependiendo de los subtipos de los atractivos que lo conforman
     */
    public function scopeSubtipos(){
        $parroquia_id = $this->id;

        return Subtipo::whereIn('id',function($sq) use($parroquia_id){
            $sq->select('subtipo_id');
            $sq->from('lugar_subtipo');
            $sq->whereIn('lugar_id',function($sq) use($parroquia_id){
                $sq->select('id');
                $sq->from('lugares');
                $sq->where('parroquia_id',$parroquia_id);
            });
        });
    }

    /**
     * En una parroquia puede tener varios subtipos, 
     * dependiendo de los subtipos de los atractivos que lo conforman
     */
    public function scopeSubtiposAtractivos(){
        return $this->subtipos()->whereIn('tipo_id',function($sq){
            $sq->select('id');
            $sq->from('tipos');
            $sq->whereIn('categoria_id',[1,2]);
        });
    }

    /**
     * En una parroquia puede tener varios subtipos, 
     * dependiendo de los subtipos de los atractivos que lo conforman
     */
    public function scopeSubtiposPrestadores(){
        return $this->subtipos()->whereIn('tipo_id',function($sq){
            $sq->select('id');
            $sq->from('tipos');
            $sq->whereIn('categoria_id',[3]);
        });
    }

     /**
     * En una parroquia puede tener varios tipos, 
     * dependiendo de los subtipos de los atractivos que lo conforman
     */
    public function scopeTipos(){
        $parroquia_id = $this->id;

        return Tipo::whereIn('id',function($sq) use($parroquia_id){
            $sq->select('tipo_id');
            $sq->from('subtipos');
            $sq->whereIn('id',function($sq) use($parroquia_id){
                $sq->select('subtipo_id');
                $sq->from('lugar_subtipo');
                $sq->whereIn('lugar_id',function($sq) use($parroquia_id){
                    $sq->select('id');
                    $sq->from('lugares');
                    $sq->where('parroquia_id',$parroquia_id);
                });
            });
        });
    }

    /**
     * En una parroquia puede tener varios tipos, 
     * dependiendo de los subtipos de los atractivos que lo conforman
     */
    public function scopeTiposAtractivos(){
        return $this->tipos()->whereIn('categoria_id',[1,2]);
    }

    
    /**
     * En una parroquia puede tener varios tipos, 
     * dependiendo de los subtipos de los atractivos que lo conforman
     */
    public function scopeTiposPrestadores(){
        return $this->tipos()->whereIn('categoria_id',[3]);
    }


    public function getCodigoAttribute(){
        $provincia_code = substr($this->gid2,0,-2);
        return substr($this->gid3,strlen($provincia_code)+1,-2);
    }
    
    /**
     * Devuelve la URL completa de la imagen de portada de la parroquia
     */
    public function getImagenURLAttribute(){
        return $this->imagen ? asset('images/parroquias/'.$this->imagen) : asset('images/parroquias/default.jpg');
    }
    
    /**
     * Devuelve la URL completa de la imagen de portada de la parroquia
     */
    public function getIconoURLAttribute(){
        return $this->icono ? asset('images/parroquias/'.$this->icono) : asset('images/ECU.23.8_1.svg');
    }

    
    /**
     * Devuelve la URL completa de la imagen de portada del lugar
     */
    public function getURLAttribute(){
        return '';
    }
}
