<?php

namespace Database\Factories;

use App\Helpers\SystemHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StorageTank>
 */
class StorageTankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identifier' => 'Tank-' . strtoupper($this->faker->unique()->randomLetter()),
            'user_id' => Auth::id() ?? 1,
            'fuel_type' => $this->faker->randomElement(SystemHelper::getFuelTypes()),
            'location' => $this->faker->randomElement(['Sector A', 'Sector B', 'Sector C', 'Loading Bay', 'Storage Area'])
        ];
    }
}
