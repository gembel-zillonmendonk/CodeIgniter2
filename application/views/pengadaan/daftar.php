
<div class="accordion">
    <h3 href="<?php echo site_url('/crud/view_form/ep_pgd_tender') ?>">INFORMASI UMUM</h3>
    <div></div>
    <h3 href="<?php echo site_url('/crud/view_grid/ep_pgd_item_tender') ?>">ITEM PENGADAAN</h3>
    <div></div>
    <h3 href="<?php echo site_url('/crud/view_grid/ep_pgd_dokumen') ?>">DOKUMEN PENDUKUNG</h3>
    <div></div>
    <h3 href="<?php echo site_url('/crud/view_form/ep_pgd_persiapan_tender') ?>">INFORMASI PENGADAAN</h3>
    <div></div>
</div>

<div class="accordion">
    <h3>ACTION</h3>
    <div>
        <div align="center">
            RESPON:
            <button type="button" id="kirim">KIRIM</button>
        </div>
    </div>
</div>
<script>

    $('.accordion h3').each(function(){
        var uri = $(this).attr('href');
        if(uri != '' && uri != '#'){
            var ctn = $(this).next();
            //alert($(ctn).width());
                
            if(ctn.html() == '')
                ctn.load(uri);
        }
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
    });
</script>