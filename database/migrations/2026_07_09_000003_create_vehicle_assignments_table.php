<?php

use App\Enums\AssignmentStatusEnum;
use App\Enums\AssignmentTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_assignments', function (Blueprint $table) {
            $table->id();

            // --- Clés étrangères métier (RESTRICT : on ne supprime pas un véhicule/chauffeur qui a des affectations) ---
            $table->foreignId('vehicle_id')->constrained('vehicles')->restrictOnDelete();
            $table->foreignId('driver_id')->constrained('drivers')->restrictOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();

            // --- Dates d'affectation ---
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // --- Statut et type ---
            $table->string('status')->default(AssignmentStatusEnum::Pending->value);
            $table->string('assignment_type')->default(AssignmentTypeEnum::Primary->value);

            // --- Notes ---
            $table->text('notes')->nullable();

            // --- Traçabilité ---
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // --- Index conseillés ---
            $table->index('vehicle_id');
            $table->index('driver_id');
            $table->index('assigned_by');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
            $table->index('created_by');
            $table->index('updated_by');
        });

        // =====================================================================
        // RÈGLE D'OR — Index uniques partiels (PostgreSQL uniquement)
        //
        // Ces index garantissent au niveau base de données qu'un véhicule
        // et qu'un chauffeur ne peuvent avoir qu'UNE SEULE affectation active
        // non supprimée à la fois. C'est un filet de sécurité en complément
        // de la validation applicative dans le Service.
        // =====================================================================

        DB::statement('
            CREATE UNIQUE INDEX vehicle_assignments_vehicle_active_unique
            ON vehicle_assignments (vehicle_id)
            WHERE status = \'active\' AND deleted_at IS NULL
        ');

        DB::statement('
            CREATE UNIQUE INDEX vehicle_assignments_driver_active_unique
            ON vehicle_assignments (driver_id)
            WHERE status = \'active\' AND deleted_at IS NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_assignments');
    }
};
