/* Formatted on 10/09/2012 11:30:54 (QP5 v5.215.12089.38647) */
CREATE OR REPLACE PROCEDURE PROC_EP_VENDOR_DELETE (
   p_kode_vendor   IN     INTEGER,
   o_is_success       OUT INTEGER)
IS
BEGIN
   DELETE FROM EP_VENDOR
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_AGEN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_AKTA
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_ALAMAT
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_BANK
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_BARANG
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_DEWAN_DIREKSI
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_IJIN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_INFORMASI_LAIN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_JASA
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_KINERJA
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_LAPORAN_KEUANGAN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_PENGALAMAN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_PERALATAN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_SERTIFIKAT
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TENAGA_KERJA
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TIPE
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_WILAYAH
         WHERE kode_vendor = p_kode_vendor;



   COMMIT;
EXCEPTION
   WHEN OTHERS
   THEN
      raise_application_error (
         -20001,
         'An error was encountered - ' || SQLCODE || ' -ERROR- ' || SQLERRM);
END;