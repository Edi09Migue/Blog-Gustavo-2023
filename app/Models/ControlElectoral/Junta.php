<?php

namespace App\Models\ControlElectoral;

use App\Models\Geo\Canton;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Junta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory, SoftDeletes;

    protected $table = "juntas";

    protected $fillable  = [
        'codigo',
        'recinto_id',
        'tipo',
    ];

    public function recinto()
    {
        return $this->belongsTo(Recinto::class);
    }



}