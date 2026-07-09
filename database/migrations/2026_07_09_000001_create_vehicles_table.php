<?php

use App\Enums\FuelTypeEnum;
use App\Enums\VehicleStatusEnum;
use App\Enums\VehicleTypeEnum;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // --- Identification ---
            $table->string('registration_number');
            $table->string('brand');
            $table->string('model');
            $table->smallInteger('year');

            // --- Classification ---
            $table->string('vehicle_type');
            $table->string('fuel_type');

            // --- Caractéristiques ---
            $table->string('color')->nullable();
            $table->unsignedInteger('mileage_km')->default(0);
            $table->date('registration_date')->nullable();

            // --- Statut ---
            $table->string('status')->default(VehicleStatusEnum::Available->value);

            // --- Notes ---
            $table->text('notes')->nullable();

            // --- Traçabilité ---
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // --- Index conseillés ---
            $table->index('status');
            $table->index('vehicle_type');
            $table->index('fuel_type');
            $table->index('created_by');
            $table->index('updated_by');
        });

        // PostgreSQL Partial Unique Index for SoftDeletes
        \Illuminate\Support\Facades\DB::statement('CREATE UNIQUE INDEX vehicles_registration_unique ON vehicles (registration_number) WHERE deleted_at IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
