<?php

namespace Database\Factories\Geo;

use App\Models\Geo\Pais;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaisFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pais::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gid0 = $this->faker->countryCode;

        return [
            'gid0'   => $gid0, //pais
            'nombre' => $this->faker->city,
            'slug'   => $this->faker->slug,
            'codigo'   => $gid0,            
            'orden'      => rand(1,256),
            'minx'      => $this->faker->latitude,
            'miny'      => $this->faker->longitude,
            'maxx'      => $this->faker->latitude,
            'maxy'      => $this->faker->longitude,
            'lat'       => $this->faker->latitude,
            'lng'       => $this->faker->longitude,
            'zoom'      => rand(1,18),
            'estado'    => $this->faker->boolean,
            'pitch'     => rand(0,90),
            'bearing'   => rand(0,90)
        ];
    }
}
