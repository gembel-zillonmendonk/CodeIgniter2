/* Formatted on 10/11/2012 16:18:55 (QP5 v5.215.12089.38647) */
CREATE OR REPLACE VIEW vw_bidder_status
AS
   SELECT -8 AS status, 'Kalah evaluasi harga' AS description FROM DUAL
   UNION ALL
   SELECT -7 AS status, 'Tidak lolos verifikasi' AS description FROM DUAL
   UNION ALL
   SELECT -5 AS status, 'Tidak lulus evaluasi teknis' AS description FROM DUAL
   UNION ALL
   SELECT -4 AS status, 'Tidak lolos verifikasi' AS description FROM DUAL
   UNION ALL
   SELECT -3 AS status, 'Tidak mengirim penawaran' AS description FROM DUAL
   UNION ALL
   SELECT -2 AS status, 'Tidak mengikuti pengadaan' AS description FROM DUAL
   UNION ALL
   SELECT -1 AS status, 'Tidak mengikuti pengadaan' AS description FROM DUAL
   UNION ALL
   SELECT 1 AS status, 'Belum mendaftar' AS description FROM DUAL
   UNION ALL
   SELECT 2 AS status, 'Belum mengirim penawaran' AS description FROM DUAL
   UNION ALL
   SELECT 3 AS status, 'Edit / kirim ulang penawaran' AS description FROM DUAL
   UNION ALL
   SELECT 4 AS status, 'Lolos verifikasi' AS description FROM DUAL
   UNION ALL
   SELECT 5 AS status, 'Lulus evaluasi teknis' AS description FROM DUAL
   UNION ALL
   SELECT 6 AS status, 'Masa sanggan teknis' AS description FROM DUAL
   UNION ALL
   SELECT 7 AS status, 'Lolos verifikasi' AS description FROM DUAL
   UNION ALL
   SELECT 8 AS status, 'Dicalonkan menjadi pemenang' AS description FROM DUAL
   UNION ALL
   SELECT 9 AS status, 'Masa sanggah harga' AS description FROM DUAL
   UNION ALL
   SELECT 10 AS status, 'Negosiasi' AS description FROM DUAL
   UNION ALL
   SELECT 11 AS status, 'Penunjukan pemenang' AS description FROM DUAL
   UNION ALL
   SELECT 20 AS status, 'Belum mengirim penawaran' AS description FROM DUAL
   UNION ALL
   SELECT 21 AS status, 'Edit / kirim ulang penawaran' AS description FROM DUAL
   UNION ALL
   SELECT 22 AS status, 'Pembukaan penawaran teknis' AS description FROM DUAL
   UNION ALL
   SELECT 23 AS status, 'Pembukaan penawaran harga' AS description FROM DUAL
   UNION ALL
   SELECT 24 AS status, 'Selesai (pengadaan telah komplit)' AS description FROM DUAL
   UNION ALL
   SELECT 25 AS status, 'Selesai (pengadaan diulang)' AS description FROM DUAL
   UNION ALL
   SELECT 26 AS status, 'Selesai (pengadaan dibatalkan)' AS description FROM DUAL
     

/* Formatted on 10/11/2012 16:30:02 (QP5 v5.215.12089.38647) */     
CREATE OR REPLACE VIEW vw_ext_todo
as
SELECT d.KODE_VENDOR,
       a.KODE_TENDER,
       a.JUDUL_PEKERJAAN,
       a.KODE_KANTOR,
       c.TGL_PEMBUKAAN_REG,
       c.TGL_PENUTUPAN_REG,
       CASE
          WHEN c.TGL_LELANG_TEKNIS IS NULL THEN c.TGL_LELANG_KOMODITI
          ELSE c.TGL_LELANG_TEKNIS
       END
          AS bid_date,
       COALESCE (f.description, 'Pendaftaran') AS current_status,
       COALESCE (e.STATUS, 1) AS STATUS,
       b.AKTIFITAS,
       -999 AS pqe_id
  FROM EP_PGD_TENDER a
       INNER JOIN EP_PGD_KOMENTAR_TENDER b
          ON a.KODE_TENDER = b.KODE_TENDER
       INNER JOIN EP_PGD_PERSIAPAN_TENDER c
          ON a.KODE_TENDER = c.KODE_TENDER
       INNER JOIN EP_PGD_TENDER_VENDOR d
          ON a.KODE_TENDER = d.KODE_TENDER
       LEFT OUTER JOIN EP_PGD_TENDER_VENDOR_STATUS e
          ON e.KODE_VENDOR = d.KODE_VENDOR AND e.KODE_TENDER = a.KODE_TENDER
       LEFT OUTER JOIN vw_bidder_status f
          ON f.STATUS = e.STATUS