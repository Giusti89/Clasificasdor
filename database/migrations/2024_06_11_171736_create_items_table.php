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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->decimal('costo', 15, 2)->nullable();
            $table->decimal('punitario', 15, 2)->nullable();
            $table->decimal('cantidad', 15, 2);
            $table->text('image_url')->nullable();

            $table->unsignedBigInteger('requerimiento_id');
            $table->foreign('requerimiento_id')->references('id')->on('requerimientos');

            $table->unsignedBigInteger('peconomica_id')->nullable();
            $table->foreign('peconomica_id')->references('id')->on('peconomicas');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
