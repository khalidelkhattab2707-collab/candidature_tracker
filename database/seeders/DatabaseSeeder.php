<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\Entretien;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user->candidatures()->saveMany(
            Candidature::factory()->count(12)->make()->each(function ($c) use ($user) {
                $c->user_id = $user->id;
                $c->save();
                $c->entretiens()->saveMany(
                    Entretien::factory()->count(rand(0, 3))->make()->each(function ($e) use ($c) {
                        $e->candidature_id = $c->id;
                    })
                );
            })
        );
    }
}
