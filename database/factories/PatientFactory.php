<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'registration_number' => 'REG-' . Str::upper(Str::random(6)),
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'medical_record' => $this->faker->sentence,
        ];
    }
}
