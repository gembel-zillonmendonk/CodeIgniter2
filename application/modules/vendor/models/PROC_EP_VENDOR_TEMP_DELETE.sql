/* Formatted on 10/09/2012 11:30:54 (QP5 v5.215.12089.38647) */
CREATE OR REPLACE PROCEDURE PROC_EP_VENDOR_TEMP_DELETE (
   p_kode_vendor   IN     INTEGER)
IS
BEGIN
   DELETE FROM EP_VENDOR_TEMP
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_AGEN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_AKTA
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_ALAMAT
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_BANK
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_BARANG
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_DEWAN_DIREKSI
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_IJIN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_INFORMASI_LAIN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_JASA
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_KINERJA
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_LAP_KEUANGAN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_PENGALAMAN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_PERALATAN
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_SERTIFIKAT
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_TENAGA_KERJA
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_TIPE
         WHERE kode_vendor = p_kode_vendor;


   DELETE FROM EP_VENDOR_TEMP_WILAYAH
         WHERE kode_vendor = p_kode_vendor;



   COMMIT;
EXCEPTION
   WHEN OTHERS
   THEN
      raise_application_error (
         -20001,
         'An error was encountered - ' || SQLCODE || ' -ERROR- ' || SQLERRM);
END;