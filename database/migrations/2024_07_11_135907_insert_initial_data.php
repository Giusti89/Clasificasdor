<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        // Insertar usuario en la tabla 'users'
        DB::table('users')->insert([
            [
                'name' => 'Giusti',
                'email' => 'giusti.17@hotmail.com',
                'password' => Hash::make('17041989'),
                'rol_id' => 1,
            ],
        ]);
        $userId = DB::table('users')->where('email', 'giusti.17@hotmail.com')->value('id');

        // Insertar datos en la tabla 'carrera_user'
        DB::table('carrera_user')->insert([
            [
                'carrera_id' => $carreraId,
                'user_id' => $userId,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        DB::table('carrera_user')->where('user_id', function ($query) {
            $query->select('id')->from('users')->where('email', 'giusti.17@hotmail.com');
        })->delete();

        
        DB::table('presupuestos')->where('carrera_id', function ($query) {
            $query->select('id')->from('carreras')->where('nombre', 'Administracción');
        })->delete();

      
        DB::table('users')->where('email', 'giusti.17@hotmail.com')->delete();

       
        DB::table('carreras')->where('nombre', 'Administracción')->delete();
    }
};
