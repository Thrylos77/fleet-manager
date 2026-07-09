<?php

use App\Enums\DriverStatusEnum;
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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            // --- Lien compte applicatif (optionnel, 1-to-1) ---
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // --- Identité ---
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email')->nullable();

            // --- Permis de conduire ---
            $table->string('license_number');
            $table->string('license_category');
            $table->date('license_expiry_date')->nullable();

            // --- Statut ---
            $table->string('status')->default(DriverStatusEnum::Available->value);

            // --- Informations complémentaires ---
            $table->text('address')->nullable();
            $table->date('hire_date')->nullable();
            $table->text('notes')->nullable();

            // --- Traçabilité ---
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // --- Index conseillés ---
            $table->index('status');
            $table->index('created_by');
            $table->index('updated_by');
        });

        // PostgreSQL Partial Unique Indexes for SoftDeletes
        \Illuminate\Support\Facades\DB::statement('CREATE UNIQUE INDEX drivers_user_id_unique ON drivers (user_id) WHERE user_id IS NOT NULL AND deleted_at IS NULL');
        \Illuminate\Support\Facades\DB::statement('CREATE UNIQUE INDEX drivers_phone_unique ON drivers (phone) WHERE deleted_at IS NULL');
        \Illuminate\Support\Facades\DB::statement('CREATE UNIQUE INDEX drivers_email_unique ON drivers (email) WHERE email IS NOT NULL AND deleted_at IS NULL');
        \Illuminate\Support\Facades\DB::statement('CREATE UNIQUE INDEX drivers_license_unique ON drivers (license_number) WHERE deleted_at IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
