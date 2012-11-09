/* Formatted on 10/09/2012 11:06:55 (QP5 v5.215.12089.38647) */
CREATE OR REPLACE PROCEDURE PROC_EP_VENDOR_COPY_TO_TEMP (
   p_kode_vendor   IN     INTEGER)
IS
   v_kode_vendor_hist   INTEGER;
BEGIN
   SELECT MAX (nomorurut) + 1
     INTO v_kode_vendor_hist
     FROM ep_nomorurut
    WHERE kode_nomorurut = 'VENDOR_TEMP';


   INSERT INTO EP_VENDOR_TEMP
      SELECT EP_VENDOR.*
        FROM EP_VENDOR
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_AGEN
      SELECT EP_VENDOR_AGEN.*
        FROM EP_VENDOR_AGEN
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_AGEN
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_AKTA
      SELECT EP_VENDOR_AKTA.*
        FROM EP_VENDOR_AKTA
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_AKTA
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_ALAMAT
      SELECT EP_VENDOR_ALAMAT.*
        FROM EP_VENDOR_ALAMAT
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_ALAMAT
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_BANK
      SELECT EP_VENDOR_BANK.*
        FROM EP_VENDOR_BANK
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_BANK
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_BARANG
      SELECT EP_VENDOR_BARANG.*
        FROM EP_VENDOR_BARANG
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_BARANG
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_DEWAN_DIREKSI
      SELECT EP_VENDOR_DEWAN_DIREKSI.*
        FROM EP_VENDOR_DEWAN_DIREKSI
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_DEWAN_DIREKSI
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_IJIN
      SELECT EP_VENDOR_IJIN.*
        FROM EP_VENDOR_IJIN
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_IJIN
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_INFORMASI_LAIN
      SELECT EP_VENDOR_INFORMASI_LAIN.*
        FROM EP_VENDOR_INFORMASI_LAIN
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_INFORMASI_LAIN
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_JASA
      SELECT EP_VENDOR_JASA.*
        FROM EP_VENDOR_JASA
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_JASA
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_KINERJA
      SELECT EP_VENDOR_KINERJA.*
        FROM EP_VENDOR_KINERJA
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_KINERJA
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_LAP_KEUANGAN
      SELECT EP_VENDOR_LAPORAN_KEUANGAN.*
        FROM EP_VENDOR_LAPORAN_KEUANGAN
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_LAP_KEUANGAN
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_PENGALAMAN
      SELECT EP_VENDOR_PENGALAMAN.*
        FROM EP_VENDOR_PENGALAMAN
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_PENGALAMAN
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_PERALATAN
      SELECT EP_VENDOR_PERALATAN.*
        FROM EP_VENDOR_PERALATAN
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_PERALATAN
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_SERTIFIKAT
      SELECT EP_VENDOR_SERTIFIKAT.*
        FROM EP_VENDOR_SERTIFIKAT
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_SERTIFIKAT
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_TENAGA_KERJA
      SELECT EP_VENDOR_TENAGA_KERJA.*
        FROM EP_VENDOR_TENAGA_KERJA
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_TENAGA_KERJA
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_TIPE
      SELECT EP_VENDOR_TIPE.*
        FROM EP_VENDOR_TIPE
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_TIPE
                      WHERE kode_vendor = p_kode_vendor);

   INSERT INTO EP_VENDOR_TEMP_WILAYAH
      SELECT EP_VENDOR_WILAYAH.*
        FROM EP_VENDOR_WILAYAH
       WHERE     kode_vendor = p_kode_vendor
             AND NOT EXISTS
                    (SELECT kode_vendor
                       FROM EP_VENDOR_TEMP_WILAYAH
                      WHERE kode_vendor = p_kode_vendor);


   COMMIT;
EXCEPTION
   WHEN OTHERS
   THEN
      raise_application_error (
         -20001,
         'An error was encountered - ' || SQLCODE || ' -ERROR- ' || SQLERRM);
END;