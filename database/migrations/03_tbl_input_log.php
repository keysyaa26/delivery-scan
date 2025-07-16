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
        Schema::create('tb_input_log', function (Blueprint $table) {
            $table->id();
            $table->string('customer_tbl')->nullable();
            $table->string('no_dn')->nullable();
            $table->enum('process', ['check_po', 'check_kelengkapan'])->nullable();
            $table->enum('status', ['OK', 'NG'])->default(NULL);
            $table->foreignId('scanned_by')->nullable()->constrained('tbl_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_input_log');
    }
};
