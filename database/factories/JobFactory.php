<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => substr($this->faker->jobTitle(), 0, 50),
            'company' => $this->faker->company(),
            'active' => $this->faker->boolean(),
            'stage' => $this->faker->randomElement($array = array(1,2,3,4)),
            'description' => $this->faker->sentences($nb = 3, $asText = true),
            'salary' => $this->faker->numberBetween($min = 16000, $max = 60000),
            'closing_date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 years', $timezone = 'GMT'),
            'date_applied' => $this->faker->dateTime($max = 'now'),
            'location' => $this->faker->city(),
            'cv' => 'CV_June_2020.pdf',
            'cover_letter' => 'fullstack_cover_July_2020.pdf'
        ];
    }
}
