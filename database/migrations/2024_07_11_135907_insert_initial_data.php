<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
        DB::table('presupuestos')->where('carrera_id', function ($query) {
            $query->select('id')->from('carreras')->where('nombre', 'Administracción');
        })->delete();

        DB::table('carreras')->where('nombre', 'Administracción')->delete();
    }
};
