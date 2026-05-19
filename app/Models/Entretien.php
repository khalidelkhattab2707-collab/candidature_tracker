<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entretien extends Model
{
    protected $fillable=[
       'candidature_id',
        'type',
        'date_heure',
        'notes_preparation',
        'resultat',
    ];
    protected $casts=[
        'date_heure'=>'datetime',
    ];
    const TYPE=[
        'telephonique' => 'Téléphonique',
        'visio'        => 'Visioconférence',
        'presentiel'   => 'Présentiel',
        'technique'    => 'Technique',
        'rh'           => 'Ressources Humaines',
    ];
    const RESULTAT=[
        'en_attente' => 'En attente',
        'positif'    => 'Positif',
        'negatif'    => 'Négatif',
        'en_cours'   => 'En cours',
    ];
    public function candidature():BelongsTo
    {
        return $this->belongsto(Candidature::class);
    }

}
