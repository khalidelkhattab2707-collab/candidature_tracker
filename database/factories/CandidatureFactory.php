<?php

namespace Database\Factories;

use App\Models\Candidature;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatureFactory extends Factory
{
    protected $model = Candidature::class;

    public function definition(): array
    {
        $statuts = array_keys(Candidature::STATUTS);
        $priorites = array_keys(Candidature::PRIORITES);

        return [
            'user_id' => User::factory(),
            'entreprise' => fake()->randomElement(['Stripe', 'Linear', 'Vercel', 'Figma', 'Notion', 'Google', 'Spotify', 'Framer', 'Apple', 'Microsoft']),
            'poste' => fake()->randomElement(['Frontend Engineer', 'Backend Engineer', 'Full Stack Developer', 'UX Designer', 'Product Manager', 'Data Analyst', 'DevOps Engineer', 'iOS Developer']),
            'url_offre' => fake()->optional(0.7)->url(),
            'statut' => fake()->randomElement($statuts),
            'priorite' => fake()->randomElement($priorites),
            'date_candidature' => fake()->dateTimeBetween('-3 months', 'now'),
            'notes' => fake()->optional(0.5)->sentence(),
        ];
    }
}
