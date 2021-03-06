<?php

namespace Database\Factories;

use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'empresa' => $this->faker->company,
            'telefono' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'genero' => $this->faker->randomElement(['male','female']),
            'birthdate' => $this->faker->date('Y-m-d'),
            'bio' => $this->faker->text(200),
            'idioma' => $this->faker->randomElement(['spanish','english']),
            'pais' => 'Ecuador',
            'provincia' => $this->faker->state,
            'ciudad' => $this->faker->city,
            'postalcode' => $this->faker->postcode,
            'direccion_principal' => $this->faker->address,
            'direccion_secundaria' => $this->faker->secondaryAddress,
        ];
    }
}
