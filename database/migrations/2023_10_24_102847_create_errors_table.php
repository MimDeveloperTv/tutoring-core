<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('errors', function (Blueprint $table) {
            $table->id();
            $table->string('route');
            $table->enum('status',['SEEN','NEW'])->default('NEW');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('errors');
    }
};
