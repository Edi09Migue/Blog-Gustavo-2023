<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Suscriptor extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

     use HasFactory, SoftDeletes;

     protected $table = "suscriptores";

     
    protected $fillable  = [
        'nombre',
        'email',
        'telefono',
    ];


}