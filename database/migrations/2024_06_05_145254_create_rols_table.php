<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rols', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });
        DB::table('rols')->insert([
            [
                'nombre' => 'Dir Administrativo',
            ],
            [
                'nombre' => 'Jefe de carrera',
            ],
            [
                'nombre' => 'Coordinador de carrera',
            ],
            [
                'nombre' => 'Docente de la institución',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rols');
    }
};
