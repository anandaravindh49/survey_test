<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MachineFactory extends Factory
{
    public function definition(): array
    {
        $packages = ['Package 1', 'Package 2', 'Package 3', 'Package 4', 'Package 5'];
        $states = ['Maharashtra', 'Gujarat', 'Rajasthan', 'Karnataka', 'Bihar'];
        $machineTypes = ['Trencher', 'Excavator', 'Loader', 'Crane', 'Compactor'];

        return [
            'package_name' => fake()->randomElement($packages),
            'state_name' => fake()->randomElement($states),
            'business_area' => fake()->randomElement(['N/A', 'Retail', 'Wholesale']),
            'district_name' => fake()->city(),
            'block_name' => fake()->word(),
            'machine_name' => fake()->word() . ' Machine',
            'machine_type' => fake()->randomElement($machineTypes),
            'code' => fake()->unique()->numerify('MCH###'),
            'status' => fake()->randomElement(['ACTIVE', 'INACTIVE']),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
