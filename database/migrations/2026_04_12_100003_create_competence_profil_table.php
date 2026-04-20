<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competence_profil', function (Blueprint $table) {
            $table->foreignId('competence_id')->constrained()->onDelete('cascade');
            $table->foreignId('profil_id')->constrained()->onDelete('cascade');
            $table->enum('niveau', ['debutant', 'intermediaire', 'expert']);
            $table->primary(['competence_id', 'profil_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competence_profil');
    }
};