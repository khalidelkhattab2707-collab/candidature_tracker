<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidature extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'entreprise',
        'poste',
        'url_offre',
        'statut',
        'priorite',
        'notes',
        'date_candidature',
    ];

    protected $casts = [
        'date_candidature' => 'date',
    ];

    const STATUTS = [
        'a_envoyer'  => 'fhfhfdhdfenvoyer',
        'envoyee'    => 'Envoyée',
        'en_cours'   => 'En cours',
        'entretien'  => 'Entretien planifié',
        'acceptee'   => 'Acceptée',
        'refusee'    => 'Refusée',
        'sans_suite' => 'Sans suite',
      ];
    const PRIORITES = [
        'haute'   => 'Haute',
        'moyenne' => 'Moyenne',
        'basse'   => 'Basse',
      ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entretiens(): HasMany
    {
        return $this->hasMany(Entretien::class);
    }


}
