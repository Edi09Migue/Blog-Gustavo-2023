<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CategoriaPagina extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;

    protected $table = "categoria_paginas";

    protected $fillable  = [
        'pagina_id',
        'categoria_id',
        
    ];

    public function paginas(){
        return $this->hasMany(Pagina::class);
    }
 
    public function categorias(){
        return $this->hasMany(CategoriaBlog::class);
    }


}
