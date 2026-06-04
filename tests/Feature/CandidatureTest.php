<?php

namespace Tests\Feature;

use App\Models\Candidature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidatureTest extends TestCase
{
    use RefreshDatabase;

    // ── ACCESS ─────────────────────────────────────────────────

    public function test_guest_cannot_access_candidatures()
    {
        $this->get(route('candidatures.index'))->assertRedirect(route('login'));
        $this->get(route('candidatures.create'))->assertRedirect(route('login'));
        $this->get(route('candidatures.archives'))->assertRedirect(route('login'));
    }

    public function test_guest_cannot_store_candidature()
    {
        $this->post(route('candidatures.store'), [])->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_list_own_candidatures()
    {
        $user = User::factory()->create();
        Candidature::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('candidatures.index'))
            ->assertStatus(200);
    }

    // ── CREATE ─────────────────────────────────────────────────

    public function test_user_can_create_candidature()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('candidatures.store'), [
            'entreprise' => 'Stripe',
            'poste' => 'Frontend Engineer',
            'url_offre' => 'https://stripe.com/jobs/123',
            'statut' => 'envoyee',
            'priorite' => 'haute',
            'date_candidature' => '2026-05-20',
            'notes' => 'Interesting role',
        ])->assertRedirect(route('candidatures.index'));

        $this->assertDatabaseHas('candidatures', [
            'user_id' => $user->id,
            'entreprise' => 'Stripe',
            'poste' => 'Frontend Engineer',
            'statut' => 'envoyee',
        ]);
    }

    public function test_create_candidature_requires_required_fields()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('candidatures.store'), [])
            ->assertSessionHasErrors(['entreprise', 'poste', 'statut', 'priorite', 'date_candidature']);
    }

    // ── ARCHIVE (Soft Delete) ──────────────────────────────────

    public function test_user_can_archive_candidature()
    {
        $user = User::factory()->create();
        $candidature = Candidature::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(route('candidatures.destroy', $candidature))
            ->assertRedirect(route('candidatures.index'));

        $this->assertSoftDeleted($candidature);
    }

    public function test_archived_candidature_appears_in_archives()
    {
        $user = User::factory()->create();
        $candidature = Candidature::factory()->create(['user_id' => $user->id]);
        $candidature->delete();

        $this->actingAs($user)
            ->get(route('candidatures.archives'))
            ->assertStatus(200)
            ->assertSee($candidature->poste);
    }

    // ── RESTORE ────────────────────────────────────────────────

    public function test_user_can_restore_archived_candidature()
    {
        $user = User::factory()->create();
        $candidature = Candidature::factory()->create(['user_id' => $user->id]);
        $candidature->delete();

        $this->actingAs($user)
            ->post(route('candidatures.restore', $candidature->id))
            ->assertRedirect(route('candidatures.archives'));

        $this->assertNotSoftDeleted($candidature);
    }

    // ── AUTHORIZATION ──────────────────────────────────────────

    public function test_user_cannot_archive_another_users_candidature()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $candidature = Candidature::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->delete(route('candidatures.destroy', $candidature))
            ->assertForbidden();
    }

    public function test_user_cannot_restore_another_users_candidature()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $candidature = Candidature::factory()->create(['user_id' => $owner->id]);
        $candidature->delete();

        $this->actingAs($other)
            ->post(route('candidatures.restore', $candidature->id))
            ->assertForbidden();
    }
}
