<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GendersEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_collection_id')->nullable();
            $table->string('national_code')->unique();
            $table->string('email')->unique()->nullable();
            $table->unsignedBigInteger('mobile')->unique();
            $table->string('password')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->date('birth_date');
            $table->enum('gender', GendersEnum::keys())->default('OTHERS');
            $table->string('avatar',500)->nullable();
            $table->boolean('isActive')->default(1);
            $table->string('api_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
