<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Email>
 */
class EmailFactory extends Factory
{
    protected $model = \App\Models\Email::class;

    public function definition(): array
    {
        return [
            'sender' => $this->faker->email(),
            'recipient' => $this->faker->email(),
            'subject' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'attachments' => json_encode([$this->faker->word() . '.pdf']),
        ];
    }
}
