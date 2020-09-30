<?php

namespace Database\Factories;

use App\Models\ApplicationNote;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationNote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'data' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true)
        ];
    }
}
