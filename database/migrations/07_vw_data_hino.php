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
            CREATE OR REPLACE VIEW vw_data_hino AS
            SELECT
                d.id AS id_delivery,
                d.dn_no,
                d.job_no,
                d.customerpart_no,
                d.qty_pcs,
                d.tanggal_order,
                d.plan,
                d.status,
                d.ETA,
                d.cycle,
                d.user,
                d.count_process,
                d.datetime_input,

                m.InvId,
                m.PartName,
                m.PartNo,
                m.QtyPerKbn,
                m.ModelNo,
                m.Tanggal_Order AS tgl_order_part,
                m.Tanggal_input AS input_part
            FROM
                tbl_deliveryhino as d
            LEFT JOIN
                masterpart_hino as m ON d.job_no  = m.JobNo
            ORDER BY
                d.tanggal_order DESC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_data_hino");
    }
};
