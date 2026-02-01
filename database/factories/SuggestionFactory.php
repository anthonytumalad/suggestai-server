<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Form;
use App\Models\Student;
use App\Models\Suggestion;

class SuggestionFactory extends Factory
{
    protected $model = Suggestion::class;

    protected static array $data;
    protected static int $index = 0;

    public function definition(): array
    {
        if (!isset(self::$data)) {
            self::$data = json_decode(
                file_get_contents(database_path('data/suggestions.json')),
                true
            );
        }

        $item = self::$data[self::$index % count(self::$data)];
        self::$index++;

        return [
            'form_id' => Form::factory(),

            'student_id' => $this->faker->boolean(70)
                ? Student::inRandomOrder()->value('id')
                : null,

            'suggestion' => $item['text'],
            'is_anonymous' => $this->faker->boolean(30),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
