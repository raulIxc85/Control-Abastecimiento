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
        // Eliminar la restricción CHECK existente
        DB::statement("ALTER TABLE applications DROP CONSTRAINT applications_status_check;");
        
        // Agregar la nueva restricción CHECK con el nuevo valor 'Finalizado'
        DB::statement("ALTER TABLE applications ADD CONSTRAINT applications_status_check CHECK (status IN ('Solicitado', 'Requerido', 'Pedido', 'Enviado', 'Confirmado', 'No se visualiza', 'Finalizado'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir los cambios si es necesario (eliminar la nueva restricción y agregar la anterior)
        DB::statement("ALTER TABLE applications DROP CONSTRAINT applications_status_check;");
        DB::statement("ALTER TABLE applications ADD CONSTRAINT applications_status_check CHECK (status IN ('Solicitado', 'Requerido', 'Pedido', 'Enviado', 'Confirmado', 'No se visualiza'));");
    }
};
