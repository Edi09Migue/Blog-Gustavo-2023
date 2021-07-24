<?php

namespace Database\Factories\Geo;

use App\Models\Geo\Parroquia;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParroquiaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parroquia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gid0 = $this->faker->countryCode;
        $gid1 = $gid0.'.'.rand(1,20);
        $gid2 = $gid1.'.'.rand(1,100);
        $gid3 = $gid2.'.'.rand(1,100);

        return [
            'gid0'   => $gid0, //pais
            'gid1'   => $gid1, //provincia
            'gid2'   => $gid2, //canton
            'gid3'   => $gid3, //parroquia
            'nombre' => $this->faker->city,
            'nombre_corto' => $this->faker->city,
            'slug'   => $this->faker->slug,
            'tipo'   => $this->faker->mimeType,
            'engtype' => $this->faker->mimeType,
            'descripcion'   => $this->faker->text,
            'zipcode'   => $this->faker->countryCode,
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
