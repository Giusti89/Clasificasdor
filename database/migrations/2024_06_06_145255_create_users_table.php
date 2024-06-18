<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('image_url')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->unsignedBigInteger('rol_id');
            $table->foreign('rol_id')->references('id')->on('rols');

           
        });
        DB::table('users')->insert([
            [
                'name' => 'Giusti',
                'email' => 'giusti.17@hotmail.com',
                'password' => Hash::make('17041989'),
               'rol_id'=>'1',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
