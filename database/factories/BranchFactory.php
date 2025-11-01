<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = \App\Models\Branch::class;

    public function definition()
    {
        return [
            'key' => $this->faker->unique()->lexify('branch_????'),
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'time_slot' => '09:00 - 17:00',
            'slot_capacity' => 5,
            'active' => 1,
        ];
    }
}
