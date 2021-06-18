<?php

namespace Database\Factories;

use App\Models\Configuracion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConfiguracionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Configuracion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tipos = ['string', 'text', 'int', 'bool', 'double', 'image', 'date'];

        $tipo = $this->faker->randomElement($tipos);
        $respuesta = "";
        switch ($tipo) {
            case 'string':
                $respuesta = $this->faker->word;
                break;
            case 'text':
                $respuesta = $this->faker->text;
                break;
            case 'int':
                $respuesta = rand(1, 100);
                break;
            case 'bool':
            case 'double':
                $respuesta = rand(1, 100) * 0.33;
                break;
            case 'date':
                $respuesta = $this->faker->date;
                break;
            case 'image':
                $respuesta = $this->faker->imageUrl(250);
                break;
        }
        return [
            'key'   => $this->faker->countryCode,
            'value' => $respuesta,
            'tipo'  => $tipo
        ];
    }
}