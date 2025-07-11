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
        Schema::create('check_manifest', function (Blueprint $table) {
            $table->id();
            $table->string('input_manifest')->nullable();
            $table->enum('status', ['OK', 'NG'])->default(NULL);
            $table->unsignedBigInteger('manifest_id')->nullable();
            $table->string('manifest_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_manifest');
    }
};
