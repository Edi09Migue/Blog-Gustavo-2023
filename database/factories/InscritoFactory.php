<?php

namespace Database\Factories;

use App\Models\Inscrito;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscritoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inscrito::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::select('id')->get();
        $candidatos = User::select('id')->get();

        return [
            'nombre'    =>  $this->faker->name,
            'telefono'  =>  $this->faker->phoneNumber,
            'ciudad'    =>  $this->faker->city,
            'parroquia'    =>  $this->faker->city,
            'candidato_id'    =>  $this->faker->randomElement($candidatos)->id,
            'creado_por'    =>  $this->faker->randomElement($users)->id,
        ];
    }
}
