<div class="accordion">
    <h3 href="<?php echo site_url('/contract/grid/contract.vw_ep_todo_kontrak') ?>">DAFTAR HASIL PENGADAAN UNTUK DIBUAT KONTRAK</h3>
    <div></div>
    <h3 href="<?php echo site_url('/contract/grid/contract.vw_ep_todo_persetujuan_kontrak') ?>"> DAFTAR PEKERJAAN KONTRAK</h3>
    <div></div>
    <h3 href="<?php echo site_url('/contract/grid/contract.vw_ep_todo_perubahan_kontrak') ?>"> DAFTAR PEKERJAAN ADENDUM KONTRAK</h3>
    <div></div>
    <h3 href="<?php echo site_url('/contract/grid/contract.vw_ep_todo_po') ?>"> DAFTAR PEKERJAAN WORK ORDER</h3>
    <div></div>
    <h3 href="<?php echo site_url('/contract/grid/contract.vw_ep_todo_milestone') ?>"> DAFTAR PEKERJAAN PROGRESS</h3>
    <div></div>
    <h3 href="<?php echo site_url('/contract/grid/contract.vw_ep_todo_invoice') ?>">  DAFTAR PEKERJAAN TAGIHAN</h3>
    <div></div>
</div>
<script>
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
</script>