
<div class="accordion">
    <h3 href="<?php echo site_url('/crud/form/ep_pgd_penawaran') ?>">PENAWARAN</h3>
    <div></div>
    <h3 href="<?php echo site_url('/crud/form/ep_pgd_penawaran_adm') ?>">ITEM ADMINISTRASI</h3>
    <div></div>
    <h3 href="<?php echo site_url('/crud/form/ep_pgd_penawaran_teknis') ?>">ITEM TEKNIS</h3>
    <div></div>
    <h3 href="<?php echo site_url('/crud/form/ep_pgd_item_penawaran') ?>">ITEM KOMERSIAL</h3>
    <div></div>
</div>

<p>
    <button type="button" id="batal">BATAL</button>
    <button type="button" id="cetak">Cetak</button>
    <button type="button" id="selesai">Lanjutkan ke persetujuan</button>
    <button type="button" id="lewat">Lewat & Selesai</button>
    <button type="button" id="selanjutnya">Simpan & Lanjutkan</button>
</p>
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