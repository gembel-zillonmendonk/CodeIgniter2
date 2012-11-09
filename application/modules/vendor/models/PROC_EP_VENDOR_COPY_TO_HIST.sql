/* Formatted on 10/09/2012 11:11:35 (QP5 v5.215.12089.38647) */
CREATE OR REPLACE PROCEDURE PROC_EP_VENDOR_COPY_TO_HIST (
   p_kode_vendor   IN     INTEGER,
   o_is_success       OUT INTEGER)
IS
   v_kode_vendor_hist   INTEGER;
BEGIN
   SELECT MAX (nomorurut) + 1
     INTO v_kode_vendor_hist
     FROM ep_nomorurut
    WHERE kode_nomorurut = 'VENDOR_HIST';


   INSERT INTO EP_VENDOR_HIST
      SELECT v_kode_vendor_hist, EP_VENDOR.*
        FROM EP_VENDOR
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_AGEN
      SELECT v_kode_vendor_hist, EP_VENDOR_AGEN.*
        FROM EP_VENDOR_AGEN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_AKTA
      SELECT v_kode_vendor_hist, EP_VENDOR_AKTA.*
        FROM EP_VENDOR_AKTA
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_ALAMAT
      SELECT v_kode_vendor_hist, EP_VENDOR_ALAMAT.*
        FROM EP_VENDOR_ALAMAT
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_BANK
      SELECT v_kode_vendor_hist, EP_VENDOR_BANK.*
        FROM EP_VENDOR_BANK
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_BARANG
      SELECT v_kode_vendor_hist, EP_VENDOR_BARANG.*
        FROM EP_VENDOR_BARANG
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_DEWAN_DIREKSI
      SELECT v_kode_vendor_hist, EP_VENDOR_DEWAN_DIREKSI.*
        FROM EP_VENDOR_DEWAN_DIREKSI
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_IJIN
      SELECT v_kode_vendor_hist, EP_VENDOR_IJIN.*
        FROM EP_VENDOR_IJIN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_INFORMASI_LAIN
      SELECT v_kode_vendor_hist, EP_VENDOR_INFORMASI_LAIN.*
        FROM EP_VENDOR_INFORMASI_LAIN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_JASA
      SELECT v_kode_vendor_hist, EP_VENDOR_JASA.*
        FROM EP_VENDOR_JASA
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_KINERJA
      SELECT v_kode_vendor_hist, EP_VENDOR_KINERJA.*
        FROM EP_VENDOR_KINERJA
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_LAP_KEUANGAN
      SELECT v_kode_vendor_hist, EP_VENDOR_LAPORAN_KEUANGAN.*
        FROM EP_VENDOR_LAPORAN_KEUANGAN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_PENGALAMAN
      SELECT v_kode_vendor_hist, EP_VENDOR_PENGALAMAN.*
        FROM EP_VENDOR_PENGALAMAN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_PERALATAN
      SELECT v_kode_vendor_hist, EP_VENDOR_PERALATAN.*
        FROM EP_VENDOR_PERALATAN
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_SERTIFIKAT
      SELECT v_kode_vendor_hist, EP_VENDOR_SERTIFIKAT.*
        FROM EP_VENDOR_SERTIFIKAT
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_TENAGA_KERJA
      SELECT v_kode_vendor_hist, EP_VENDOR_TENAGA_KERJA.*
        FROM EP_VENDOR_TENAGA_KERJA
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_TIPE
      SELECT v_kode_vendor_hist, EP_VENDOR_TIPE.*
        FROM EP_VENDOR_TIPE
       WHERE kode_vendor = p_kode_vendor;

   INSERT INTO EP_VENDOR_HIST_WILAYAH
      SELECT v_kode_vendor_hist, EP_VENDOR_WILAYAH.*
        FROM EP_VENDOR_WILAYAH
       WHERE kode_vendor = p_kode_vendor;



   COMMIT;
EXCEPTION
   WHEN OTHERS
   THEN
      raise_application_error (
         -20001,
         'An error was encountered - ' || SQLCODE || ' -ERROR- ' || SQLERRM);
END;