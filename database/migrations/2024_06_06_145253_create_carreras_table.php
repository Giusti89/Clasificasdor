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
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });
        
        DB::table('carreras')->insert([
            [
                'nombre' => 'Administracción',                
            ],
        ]);

        $carreraId = DB::table('carreras')->where('nombre', 'Administracción')->value('id');

        // Insertar datos en la tabla 'presupuestos'
        DB::table('presupuestos')->insert([
            [
                'monto' => 0,
                'carrera_id' => $carreraId,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
        Schema::dropIfExists('carreras');
    }
};
