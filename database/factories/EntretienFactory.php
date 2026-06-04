<?php

namespace Database\Factories;

use App\Models\Candidature;
use App\Models\Entretien;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntretienFactory extends Factory
{
    protected $model = Entretien::class;

    public function definition(): array
    {
        $types = array_keys(Entretien::TYPES);
        $resultats = array_keys(Entretien::RESULTATS);

        return [
            'candidature_id' => Candidature::factory(),
            'type' => fake()->randomElement($types),
            'date_heure' => fake()->dateTimeBetween('now', '+1 month'),
            'notes_preparation' => fake()->optional(0.6)->sentence(),
            'resultat' => fake()->randomElement($resultats),
        ];
    }
}
