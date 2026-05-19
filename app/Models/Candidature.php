<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidature extends Model
{
      use softdeletes;
      protected $fillable=[
        'user_id',
        'entreprise',
        'poste',
        'url_offre',
        'statut',
        'priorite',
        'notes',
        'date_candidature',
      ];
      protected $casts=[
        'date_candidature'=>'date',
      ];
      const status=[
        'a_envoyer'  => 'À envoyer',
        'envoyee'    => 'Envoyée',
        'en_cours'   => 'En cours',
        'entretien'  => 'Entretien planifié',
        'acceptee'   => 'Acceptée',
        'refusee'    => 'Refusée',
        'sans_suite' => 'Sans suite',
      ];
      const priorite=[
        'haute'   => 'Haute',
        'moyenne' => 'Moyenne',
        'basse'   => 'Basse',
      ];
      public function user(): belongsto
      {
         return $this->belongsto(User::class);
      }
      public function entretiens():hasmany
      {
        return $this->hasmany(Entretiens::class);
      }


}
