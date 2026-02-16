<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlockFactory extends Factory
{
    public function definition(): array
    {
        $packages = ['Package 1', 'Package 2', 'Package 3', 'Package 4', 'Package 5', 'Package 6', 'Package 7'];
        $states = ['Maharashtra', 'Gujarat', 'Rajasthan', 'Uttar Pradesh', 'Bihar', 'Jammu & Kashmir', 'Karnataka'];
        $districts = ['Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Pune', 'Kolkata', 'Jaipur', 'Lucknow', 'Ahmedabad'];
        $blocks = ['Block A', 'Block B', 'Block C', 'Block D', 'Block E', 'Block F', 'Block G', 'Block H', 'Block I', 'Block J'];

        return [
            'package_name' => fake()->randomElement($packages),
            'state_name' => fake()->randomElement($states),
            'business_area' => fake()->randomElement(['N/A', 'Retail', 'Wholesale', 'Distribution']),
            'district_name' => fake()->randomElement($districts),
            'block_name' => fake()->randomElement($blocks),
            'code' => fake()->unique()->numerify('BLK###'),
            'status' => fake()->randomElement(['ACTIVE', 'INACTIVE']),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
