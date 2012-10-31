CREATE OR REPLACE VIEW vw_ext_quotation_eval
AS
   SELECT KODE_TENDER, 
          KODE_KANTOR,
          KODE_EVAL_DETAIL,
          B.KODE_EVALUASI,
          ITEM AS KETERANGAN,
          BOBOT ,
          '' AS KETERANGAN_VENDOR,
          0 AS PQT_ID,
          0 AS PQM_ID          
     FROM EP_PGD_PERSIAPAN_TENDER a
          INNER JOIN EP_PGD_EVALUASI_MODEL b
             ON B.KODE_EVALUASI = a.KODE_EVALUASI
          INNER JOIN EP_PGD_EVALUASI_MODEL_DETAIL c
             ON c.KODE_EVALUASI = b.KODE_EVALUASI
             
             
/* Formatted on 10/15/2012 14:34:04 (QP5 v5.215.12089.38647) */
CREATE OR REPLACE VIEW vw_ext_tender_item
AS
      SELECT B.KODE_TENDER,
          C.KODE_KANTOR,
          B.KODE_VENDOR,
          C.KODE_BARANG_JASA,
          C.KODE_SUB_BARANG_JASA,
          D.NAMA_BARANG_JASA,
          coalesce(A.KETERANGAN, '') as KETERANGAN,
          coalesce(A.JUMLAH, 0) as JUMLAH,
          coalesce(A.HARGA, 0) as HARGA
     FROM EP_PGD_TENDER_VENDOR b
          RIGHT JOIN EP_PGD_ITEM_TENDER c
             ON     b.KODE_TENDER = C.KODE_TENDER
          INNER JOIN (SELECT KODE_BARANG AS KODE_BARANG_JASA,
                             KODE_SUB_BARANG AS KODE_SUB_BARANG_JASA,
                             NAMA_BARANG AS NAMA_BARANG_JASA
                        FROM MS_BARANG
                      UNION
                      SELECT KODE_JASA, KODE_KEL_JASA, NAMA_JASA
                        FROM EP_KOM_JASA) d
             ON     d.KODE_BARANG_JASA = c.KODE_BARANG_JASA
                AND d.KODE_SUB_BARANG_JASA = c.KODE_SUB_BARANG_JASA
          LEFT JOIN EP_PGD_ITEM_PENAWARAN a
          ON A.KODE_VENDOR = B.KODE_VENDOR
          AND A.KODE_TENDER = B.KODE_TENDER
          AND A.KODE_TENDER = B.KODE_TENDER
          AND A.KODE_BARANG_JASA = c.KODE_BARANG_JASA
          AND A.KODE_SUB_BARANG_JASA = c.KODE_SUB_BARANG_JASA