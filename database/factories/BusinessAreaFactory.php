<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessAreaFactory extends Factory
{
    public function definition(): array
    {
        $packages = ['Package 1', 'Package 2', 'Package 3', 'Package 4', 'Package 5'];
        $states = ['Jammu & Kashmir', 'Himachal Pradesh', 'Punjab', 'Haryana', 'Uttar Pradesh', 'Uttarakhand', 'Delhi', 'Rajasthan', 'Gujarat', 'Maharashtra', 'Karnataka', 'Tamil Nadu', 'Telangana', 'Andhra Pradesh'];
        $businesses = ['Agricultural', 'Commercial', 'Industrial', 'Retail', 'Manufacturing', 'Services', 'Tourism', 'Education', 'Healthcare', 'Technology'];

        return [
            'package_name' => fake()->randomElement($packages),
            'state_name' => fake()->randomElement($states),
            'business_name' => fake()->randomElement($businesses) . ' - ' . fake()->city(),
            'code' => fake()->unique()->numerify('###'),
            'status' => fake()->randomElement(['ACTIVE', 'INACTIVE']),
            'created_by' => null,
            'updated_by' => null,
        ];
    }
}
