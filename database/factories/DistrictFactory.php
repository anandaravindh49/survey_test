<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DistrictFactory extends Factory
{
    public function definition(): array
    {
        $packages = ['Package 1', 'Package 2', 'Package 3', 'Package 4', 'Package 5', 'Package 6', 'Package 7'];
        $states = ['Maharashtra', 'Gujarat', 'Rajasthan', 'Uttar Pradesh', 'Bihar', 'Jammu & Kashmir', 'Karnataka'];
        $districts = ['Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Pune', 'Kolkata', 'Jaipur', 'Lucknow', 'Ahmedabad'];

        return [
            'package_name' => fake()->randomElement($packages),
            'state_name' => fake()->randomElement($states),
            'business_area' => fake()->randomElement(['N/A', 'Retail', 'Wholesale', 'Distribution']),
            'district_name' => fake()->randomElement($districts),
            'code' => fake()->unique()->numerify('###'),
            'status' => fake()->randomElement(['ACTIVE', 'INACTIVE']),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
