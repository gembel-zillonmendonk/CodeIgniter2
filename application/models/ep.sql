ALTER TABLE EPROC.EP_VENDOR_DEWAN_DIREKSI
 DROP PRIMARY KEY CASCADE;

ALTER TABLE EPROC.EP_VENDOR_DEWAN_DIREKSI
 ADD PRIMARY KEY EP_VENDOR_DEWAN_DIREKSI_PK
  (KODE_VENDOR, TIPE, NAMA)
  ENABLE VALIDATE;
  
  
ALTER TABLE EPROC.EP_VENDOR_AGEN
 DROP PRIMARY KEY CASCADE;

ALTER TABLE EPROC.EP_VENDOR_AGEN
 ADD PRIMARY KEY EP_VENDOR_AGEN_PK
  (KODE_VENDOR, TIPE, NO)
  ENABLE VALIDATE;
  
  
ALTER TABLE EPROC.EP_VENDOR_IJIN
 DROP PRIMARY KEY CASCADE;

ALTER TABLE EPROC.EP_VENDOR_IJIN
 ADD PRIMARY KEY EP_VENDOR_IJIN_PK
  (KODE_VENDOR, TIPE, NO)
  ENABLE VALIDATE;
  