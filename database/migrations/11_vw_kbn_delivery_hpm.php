<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_kbn_delivery_hpm AS
            SELECT
                d.id AS id_delivery,

                d.dn_no,
                k.dn_no AS dn_no_kbn,

                d.job_no,
                k.job_no AS job_no_kbn,

                k.seq_no,
                k.kbicode,
                k.invid
            FROM
                tbl_deliveryhpm d
            LEFT JOIN
                tbl_kbndelivery k ON d.dn_no = k.dn_no
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_kbn_delivery_hpm");
    }
};
