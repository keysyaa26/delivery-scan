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
        Schema::create('tbl_check_sj', function (Blueprint $table) {
            $table->id();
            $table->string('dn_no')->nullable();
            $table->string('table_name')->nullable();
            $table->boolean('check_sj')->default(false);
            $table->integer('checked_by')->nullable();
            $table->foreign('checked_by')->references('id_user')->on('tbl_user')->onDelete('cascade');
            $table->date('checked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_check_sj', function (Blueprint $table) {
            $table->dropForeign(['checked_by']);
        });
        Schema::dropIfExists('tbl_check_sj');
    }
};
