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
            CREATE OR REPLACE VIEW vw_data_mmki AS
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
                m.Tanggal_input AS input_part,

                ROUND(d.qty_pcs / m.QtyPerKbn) AS sequence,
                (
                    SELECT COUNT(*)
                    FROM tbl_deliverynote c
                    WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                ) AS countP,

                IF(
                    ROUND(d.qty_pcs / m.QtyPerKbn)
                     =
                    (
                        SELECT COUNT(*)
                        FROM tbl_deliverynote c
                        WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                    ),
                    'Close',
                    d.status
                ) AS status_label

            FROM
                tbl_deliverynote as d
            LEFT JOIN
                masterpart_mmki as m ON d.job_no  = m.JobNo
            ORDER BY
                d.tanggal_order DESC
        ");

        DB::statement("
            CREATE OR REPLACE VIEW vw_data_suzuki AS
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
                m.Tanggal_input AS input_part,

                ROUND(d.qty_pcs / m.QtyPerKbn) AS sequence,
                (
                    SELECT COUNT(*)
                    FROM tbl_deliverysuzuki c
                    WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                ) AS countP,

                IF(
                    ROUND(d.qty_pcs / m.QtyPerKbn)
                     =
                    (
                        SELECT COUNT(*)
                        FROM tbl_deliverysuzuki c
                        WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                    ),
                    'Close',
                    d.status
                ) AS status_label

            FROM
                tbl_deliverysuzuki as d
            LEFT JOIN
                masterpart_suzuki as m ON d.job_no  = m.JobNo
            ORDER BY
                d.tanggal_order DESC
        ");

        DB::statement("
            CREATE OR REPLACE VIEW vw_data_adm AS
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
                m.Tanggal_input AS input_part,

                ROUND(d.qty_pcs / m.QtyPerKbn) AS sequence,
                (
                    SELECT COUNT(*)
                    FROM tbl_deliveryadm c
                    WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                ) AS countP,

                IF(
                    ROUND(d.qty_pcs / m.QtyPerKbn)
                     =
                    (
                        SELECT COUNT(*)
                        FROM tbl_deliveryadm c
                        WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                    ),
                    'Close',
                    d.status
                ) AS status_label

            FROM
                tbl_deliveryadm as d
            LEFT JOIN
                masterpart_adm as m ON d.job_no  = m.JobNo
            ORDER BY
                d.tanggal_order DESC
        ");

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
                m.Tanggal_input AS input_part,

                ROUND(d.qty_pcs / m.QtyPerKbn) AS sequence,
                (
                    SELECT COUNT(*)
                    FROM tbl_deliveryhino c
                    WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                ) AS countP,

                IF(
                    ROUND(d.qty_pcs / m.QtyPerKbn)
                     =
                    (
                        SELECT COUNT(*)
                        FROM tbl_deliveryhino c
                        WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                    ),
                    'Close',
                    d.status
                ) AS status_label

            FROM
                tbl_deliveryhino as d
            LEFT JOIN
                masterpart_hino as m ON d.job_no  = m.JobNo
            ORDER BY
                d.tanggal_order DESC
        ");

        DB::statement("
            CREATE OR REPLACE VIEW vw_data_tmmin AS
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
                m.Tanggal_input AS input_part,

                ROUND(d.qty_pcs / m.QtyPerKbn) AS sequence,
                (
                    SELECT COUNT(*)
                    FROM tbl_deliverytmmin c
                    WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                ) AS countP,

                IF(
                    ROUND(d.qty_pcs / m.QtyPerKbn)
                     =
                    (
                        SELECT COUNT(*)
                        FROM tbl_deliverytmmin c
                        WHERE c.dn_no = d.dn_no AND c.job_no = d.job_no
                    ),
                    'Close',
                    d.status
                ) AS status_label

            FROM
                tbl_deliverytmmin as d
            LEFT JOIN
                masterpart_tmmin as m ON d.job_no  = m.JobNo
            ORDER BY
                d.tanggal_order DESC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_data_mmki");
        DB::statement("DROP VIEW IF EXISTS vw_data_suzuki");
        DB::statement("DROP VIEW IF EXISTS vw_data_adm");
        DB::statement("DROP VIEW IF EXISTS vw_data_tmmin");
    }
};
