<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;
use App\Models\Suggestion;

class SuggestionSeeder extends Seeder
{
    public function run(): void
    {
        $forms = Form::all();

        if ($forms->isEmpty()) {
            $forms = Form::factory()->count(100)->create();
        }

        foreach ($forms as $form) {
            Suggestion::factory()
                ->count(rand(0, 10))
                ->create(['form_id' => $form->id]);
        }

        $this->command->info('Attached random suggestions to existing forms.');
    }
}
