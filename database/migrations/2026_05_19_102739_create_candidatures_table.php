<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('entreprise');
            $table->string('poste');
            $table->enum('statut', ['a_envoyer', 'envoyee', 'en_cours',
                         'entretien', 'acceptee', 'refusee', 'sans_suite']);
            $table->enum('priorite', ['haute', 'moyenne', 'basse']);
            $table->date('date_candidature');
            $table->text('notes')->nullable();
            $table->string('url_offre')->nullable();
        
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
