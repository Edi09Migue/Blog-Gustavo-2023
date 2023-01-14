<?php

namespace Database\Factories\ControlElectoral;

use App\Models\ControlElectoral\Acta;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Acta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
    
       

    //     $responsable = User::select('id')->get();
    //     $conductor = User::select('id')->get();
    //     $dependencia = Dependencia::select('id')->get();
    //     $creadoPor = User::select('id')->get();

    
        
    //     return [
         
    //         'codigo'=>$this->faker->randomElement($responsable)->id,
    //         'votos_blancos' =>$desde,
    //         'fecha_hasta' =>$hasta,
    //         'cantidad_ocupantes' => $this->faker->name,
    //         'conductor_id'=>$this->faker->randomElement($conductor)->id,
    //         'motivo' => $this->faker->text,
    //         'dependencias_id'=>$this->faker->randomElement($dependencia)->id,
    //         'lugar_destino' => $this->faker->city,
    //         //'kilometraje_inicio' => $kilometraje, 
    //         //'kilometraje_fin' => $kilometraje_final,
    //         'estado' => $this->faker->boolean,
    //         'creado_por_id' =>  $this->faker->randomElement($creadoPor)->id,
            
    //     ];
    }
}
