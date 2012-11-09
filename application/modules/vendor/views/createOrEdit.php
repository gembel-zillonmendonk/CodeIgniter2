<div class="tabs">
    <ul>
        <li><a href="#tabs-1">Data Utama</a></li>
        <li><a href="#tabs-2">Data Legal</a></li>
        <li><a href="#tabs-3">Pengurus Perusahaan</a></li>
        <li><a href="#tabs-4">Data Keuangan</a></li>
        <li><a href="#tabs-5">Barang/Jasa</a></li>
        <li><a href="#tabs-6">SDM</a></li>
        <li><a href="#tabs-7">Sertifikasi</a></li>
        <li><a href="#tabs-8">Fasilitas/Peralatan</a></li>
        <li><a href="#tabs-9">Pengalaman Proyek</a></li>
        <li><a href="#tabs-10">Data Tambahan</a></li>
    </ul>
    <!--
    <div id="tabs-1">
        <div class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons">
            <h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top"><a href="<?php echo site_url('/crud/grid/EP_VENDOR') ?>">NAMA PERUSAHAAN</h3>
            <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active"></div>
            <h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top"><a href="<?php echo site_url('/crud/grid/EP_NOMORURUT') ?>">KONTAK PERUSAHAAN</h3>
            <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active"></div>
            <h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top"><a href="#">KONTAK PERSON</h3>
            <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active"></div>
            <h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top"><a href="#">KEPESERTAAN JAMSOSTEK</h3>
            <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active"></div>
        </div>
    </div>
    -->
    <div id="tabs-1">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_perusahaan') ?>">NAMA PERUSAHAAN</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/grid_form/ep_vendor_alamat') ?>">KONTAK PERUSAHAAN</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_kontak_person') ?>">KONTAK PERSON</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_jamsostek') ?>">KEPESERTAAN JAMSOSTEK</h3>
            <div></div>
        </div>
    </div>

    <div id="tabs-2">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_akta') ?>">AKTA PENDIRIAN</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_domisili') ?>">DOMISILI PERUSAHAAN</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_npwp') ?>">NPWP</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_mitra') ?>">JENIS MITRA KERJA</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_siup') ?>">SIUP</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_ijin') ?>">IJIN LAIN-LAIN (OPSIONAL)</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_tdp') ?>">TDP</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_agen') ?>">SURAT KEAGENAN/DISTRIBUTORSHIP (OPSIONAL)</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_importir') ?>">ANGKA PENGENAL IMPORTIR (OPSIONAL)</h3>
            <div></div>
        </div>
    </div>

    <div id="tabs-3">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_komisaris') ?>">DEWAN KOMISARIS</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_direksi') ?>">DEWAN DIREKSI</h3>
            <div></div>
        </div>
    </div>

    <div id="tabs-4">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_bank') ?>">REKENING BANK</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_modal') ?>">MODAL SESUAI DENGAN AKTA TERAKHIR</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_laporan_keuangan') ?>">INFORMASI LAPORAN KEUANGAN</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_klasifikasi') ?>">KLASIFIKASI PERUSAHAAN</h3>
            <div></div>
        </div>
    </div>

    <div id="tabs-5">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_barang') ?>">BARANG YANG BISA DIPASOK</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_jasa') ?>">JASA YANG BISA DIPASOK</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/grid_form/ep_vendor_wilayah') ?>">AREA KERJA</h3>
            <div></div>
        </div>
    </div>

    <div id="tabs-6">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_tenaga_utama') ?>">TENAGA AHLI UTAMA</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_tenaga_pendukung') ?>">TENAGA AHLI PENDUKUNG</h3>
            <div></div>
        </div>
    </div>

    <div id="tabs-7">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_sertifikat') ?>">KETERANGAN SERTIFIKAT</h3>
            <div></div>
        </div>
    </div>

    <div id="tabs-8">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/grid/ep_vendor_peralatan') ?>">KETERANGAN TENTANG FASILITAS / PERALATAN</h3>
            <div></div>
        </div>
    </div>

    <div id="tabs-9">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/grid_form/ep_vendor_pengalaman') ?>">PEKERJAAN</h3>
            <div></div>
        </div>
    </div>

    <div id="tabs-10">
        <div class="accordion">
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_principal') ?>">PRINCIPAL</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_subkontraktor') ?>">SUBKONTRAKTOR</h3>
            <div></div>
            <h3 href="<?php echo site_url('/crud/form/ep_vendor_afiliasi') ?>">PERUSAHAAN AFILIASI</h3>
            <div></div>
        </div>
    </div>
</div>
<p>
    <button type="button" id="batal">BATAL</button>
    <button type="button" id="cetak">Cetak</button>
    <button type="button" id="selesai">Lanjutkan ke persetujuan</button>
    <button type="button" id="lewat">Lewat & Selesai</button>
    <button type="button" id="selanjutnya">Simpan & Lanjutkan</button>
</p>
<script>
    // Tabs
    $('.tabs').tabs({
        show: function(event, ui) {
            $(".accordion", ui.panel).each(function(){
                //alert("test");
                
                $('h3', $(this)).each(function(){
                    var uri = $(this).attr('href');
                    if(uri != '' && uri != '#'){
                        var ctn = $(this).next();
                        //alert($(ctn).width());
                        //alert(uri);
                        if(ctn.html() == '')
                            ctn.load(uri);
                    }
                });
            });
        }
    });

    /*
        $('.accordion').accordion({
            active:false,
            //collapsible:true,
            change:function(event, ui) {
                if(ui.newContent.html()==''){
                    ui.newContent.load(ui.newHeader.find('a').attr('href'));
                }
            },
            create:function(event, ui){
                //alert($(this).html());
            },
            autoHeight: false
        }).css("width", "auto");
     */
    $(".accordion")
    .addClass("ui-accordion ui-widget ui-helper-reset")
    //.css("width", "auto")
    .find('h3')
    .addClass("current ui-accordion-header ui-helper-reset ui-state-active ui-corner-top")
    .css("padding", ".5em .5em .5em .7em")
    //.prepend('<span class="ui-icon ui-icon-triangle-1-s"><span/>')
    .next()
    .addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active")
    .css('overflow','visible')
    //.css("width", "auto");
    /*
        .parent().each(function(){
            $('a', $(this)).each(function(){
                var uri = $(this).attr('href');
                if(uri != '' && uri != '#'){
                    var ctn = $(this).parent().next();
                    //alert($(this).parent().parent().parent().width());
                    //alert(uri);
                    if(ctn.html() == '')
                        ctn.load(uri);
                }
            });
        });
     */
        
        
    $(document).ready(function(){
        
        // event for verifikasi all object
        $('#selesai').live('click', function(){
            $.ajax({
                url:'<?php echo site_url('/vendor/activation') ?>', 
                success:function(responseText, textStatus, XMLHttpRequest) {
                    if(jQuery.parseJSON(responseText)){
                        var cList = $('<ul></ul>');
                        $.each(jQuery.parseJSON(responseText)['errors'], function(i, v){
                            $('<li></li>').text(v['message']).appendTo(cList);
                        });
                        $('#error-box p').append(cList).parent().show();
                    }
                    else{
                        alert('success!!');
                    }
                }
            });
        });
        /*
            $(".accordion").each(function(){
                //alert("test");
                
                $('h3', $(this)).each(function(){
                    var uri = $(this).attr('href');
                    if(uri != '' && uri != '#'){
                        var ctn = $(this).next();
                        //alert($(ctn).width());
                        //alert(uri);
                        if(ctn.html() == '')
                            ctn.load(uri);
                    }
                });
            });
         */
        /*
            $('.tabs div').each(function(){
                //alert($(this).html());
                $('a', $(this)).each(function(){
                    var uri = $(this).attr('href');
                    if(uri != '' && uri != '#'){
                        var ctn = $(this).parent().next();
                        //alert($(ctn).width());
                        //alert(uri);
                        if(ctn.html() == '')
                            ctn.load(uri);
                    }
                });
            });
         */
    });
</script>