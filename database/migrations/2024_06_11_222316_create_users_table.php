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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user', length: 100);
            $table->string('password', length: 100);
            $table->string('name', length: 100);
            $table->integer('status')->comment('1:habilitado 2:pendiente 3:deshabilitado');
            $table->integer('rol')->comment('1:user 2:supervisor 3:admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
