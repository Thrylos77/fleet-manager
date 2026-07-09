<?php

use App\Enums\UserStatusEnum;
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
            $table->string('name');
            $table->string('username');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('status')->default(UserStatusEnum::Active->value);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // Index conseillés (email déjà indexé via unique)
            $table->index('status');
            $table->index('deleted_at');
        });

        // PostgreSQL Partial Unique Indexes for SoftDeletes
        \Illuminate\Support\Facades\DB::statement('CREATE UNIQUE INDEX users_username_unique ON users (username) WHERE deleted_at IS NULL');
        \Illuminate\Support\Facades\DB::statement('CREATE UNIQUE INDEX users_email_unique ON users (email) WHERE deleted_at IS NULL');
        \Illuminate\Support\Facades\DB::statement('CREATE UNIQUE INDEX users_phone_unique ON users (phone) WHERE phone IS NOT NULL AND deleted_at IS NULL');

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
