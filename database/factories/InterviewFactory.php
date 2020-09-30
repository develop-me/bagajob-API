<?php

namespace Database\Factories;

use App\Models\Interview;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Interview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'interview_date' => $this->faker->date(),
            'format' => $this->faker->randomElement($array = array ('online_testing','telephone', 'video_call', 'in_person',)),
            'interviewer' => $this->faker->name(),
            'notes' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true)
        ];
    }
}
