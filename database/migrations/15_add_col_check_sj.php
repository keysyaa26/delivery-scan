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
        Schema::table('tbl_deliveryhpm', function (Blueprint $table) {
           $table->boolean('check_sj')->nullable();
           $table->integer('checked_by')->nullable();
           $table->foreign('checked_by')->references('id_user')->on('tbl_user')->onDelete('cascade');
           $table->date('checked_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_deliveryhpm', function (Blueprint $table) {
            $table->dropColumn(['check_sj', 'checked_by', 'checked_at']);
        });
    }
};
