/* Formatted on 10/09/2012 11:37:43 (QP5 v5.215.12089.38647) */
CREATE OR REPLACE PROCEDURE PROC_EP_VENDOR_EDIT_FROM_TEMP (
   p_kode_vendor   IN     INTEGER,
   o_is_success       OUT INTEGER)
IS
BEGIN
   /*delete ep_vendor first*/
   PROC_EP_VENDOR_DELETE (p_kode_vendor, o_is_success);

   INSERT INTO EP_VENDOR
      SELECT EP_VENDOR_TEMP.*
        FROM EP_VENDOR_TEMP
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_AGEN
      SELECT EP_VENDOR_TEMP_AGEN.*
        FROM EP_VENDOR_TEMP_AGEN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_AKTA
      SELECT EP_VENDOR_TEMP_AKTA.*
        FROM EP_VENDOR_TEMP_AKTA
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_ALAMAT
      SELECT EP_VENDOR_TEMP_ALAMAT.*
        FROM EP_VENDOR_TEMP_ALAMAT
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_BANK
      SELECT EP_VENDOR_TEMP_BANK.*
        FROM EP_VENDOR_TEMP_BANK
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_BARANG
      SELECT EP_VENDOR_TEMP_BARANG.*
        FROM EP_VENDOR_TEMP_BARANG
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_DEWAN_DIREKSI
      SELECT EP_VENDOR_TEMP_DEWAN_DIREKSI.*
        FROM EP_VENDOR_TEMP_DEWAN_DIREKSI
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_IJIN
      SELECT EP_VENDOR_TEMP_IJIN.*
        FROM EP_VENDOR_TEMP_IJIN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_INFORMASI_LAIN
      SELECT EP_VENDOR_TEMP_INFORMASI_LAIN.*
        FROM EP_VENDOR_TEMP_INFORMASI_LAIN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_JASA
      SELECT EP_VENDOR_TEMP_JASA.*
        FROM EP_VENDOR_TEMP_JASA
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_KINERJA
      SELECT EP_VENDOR_TEMP_KINERJA.*
        FROM EP_VENDOR_TEMP_KINERJA
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_LAPORAN_KEUANGAN
      SELECT EP_VENDOR_TEMP_LAP_KEUANGAN.*
        FROM EP_VENDOR_TEMP_LAP_KEUANGAN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_PENGALAMAN
      SELECT EP_VENDOR_TEMP_PENGALAMAN.*
        FROM EP_VENDOR_TEMP_PENGALAMAN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_PERALATAN
      SELECT EP_VENDOR_TEMP_PERALATAN.*
        FROM EP_VENDOR_TEMP_PERALATAN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_SERTIFIKAT
      SELECT EP_VENDOR_TEMP_SERTIFIKAT.*
        FROM EP_VENDOR_TEMP_SERTIFIKAT
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_TENAGA_KERJA
      SELECT EP_VENDOR_TEMP_TENAGA_KERJA.*
        FROM EP_VENDOR_TEMP_TENAGA_KERJA
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_TIPE
      SELECT EP_VENDOR_TEMP_TIPE.*
        FROM EP_VENDOR_TEMP_TIPE
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_WILAYAH
      SELECT EP_VENDOR_TEMP_WILAYAH.*
        FROM EP_VENDOR_TEMP_WILAYAH
       WHERE kode_vendor = p_kode_vendor;

   /*delete ep_vendor_temp after all*/
   PROC_EP_VENDOR_TEMP_DELETE (p_kode_vendor, o_is_success);

   COMMIT;
EXCEPTION
   WHEN OTHERS
   THEN
      raise_application_error (
         -20001,
         'An error was encountered - ' || SQLCODE || ' -ERROR- ' || SQLERRM);
END;