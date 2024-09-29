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
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->String('tu',25)->nullable();
            $table->foreignUuid('piloto_id')->nullable()->contrained();
            $table->foreignUuid('applicant_id')->nullable()->contrained();
            $table->enum('status', ['Solicitado', 'Requerido','Pedido','Enviado','Confirmado','No se visualiza']);
            $table->integer('quantity')->default(0);
            $table->String('transport', 100)->nullable();
            $table->String('capacity', 50)->nullable();
            $table->foreignUuid('origin_agency_id')->contrained('agencies');
            $table->foreignUuid('destination_agency_id')->contrained('agencies');
            $table->foreignUuid('user_id')->contrained('users');
            $table->foreignUuid('modified_user_id')->nullable()->contrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
