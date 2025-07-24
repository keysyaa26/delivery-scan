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
        DB::table('
            CREATE OR REPLACE VIEW vw_kbndelivery_hpm AS
            select
            	b.kbndn_no,
                a.dn_no,
                a.job_no,
                b.seq_no,
                a.InvId,
                a.PartName,
                a.status_label,
            	a.tanggal_order,
                b.check_leader,
                b.checked_by
            FROM
                vw_data_hpm a
            LEFT JOIN
                tbl_kbndelivery b
            ON
                a.dn_no = b.dn_no
            AND
                a.job_no = b.job_no
            AND
                a.InvId = b.invid
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_kbndelivery_hpm");
    }
};
