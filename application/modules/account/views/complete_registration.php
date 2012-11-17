<?php echo Modules::run('vendor/_editor'); ?> 
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
        selected: <?php echo $active_tabs; ?>,
        disabled: <?php echo $disable_tabs; ?>,
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
        
        // event for verifikasi object per page
        $('#selanjutnya').live('click', function(){
            $.ajax({
                url:'<?php echo site_url('/account/complete_registration') ?>', 
                success:function(responseText, textStatus, XMLHttpRequest) {
                    responseText = responseText.length > 0 ? responseText : '[]';
                    var $data = jQuery.parseJSON(responseText);
                    if($data.hasOwnProperty('errors')){
                        var cList = $('<ul></ul>');
                        $.each($data['errors'], function(i, v){
                            $('<li></li>').text(v['message']).appendTo(cList);
                        });
                        $('#error-box p').html(cList).parent().show();
                    }
                    else{
                        $('#error-box p').html(cList).parent().hide();
                        $('.tabs')
                        .tabs('enable', $data['active_tabs'] )
                        .tabs('select', $data['active_tabs']);
                        //$('.tabs').tabs('option', 'disabled', $data['disable_tabs'] );
                        
                    }
                }
            });
        });
        
        // event for verifikasi all object
        $('#selesai').live('click', function(){
            $.ajax({
                url:'<?php echo site_url('/account/activation') ?>', 
                success:function(responseText, textStatus, XMLHttpRequest) {
                    if(jQuery.parseJSON(responseText)){
                        var cList = $('<ul></ul>');
                        $.each(jQuery.parseJSON(responseText)['errors'], function(i, v){
                            $('<li></li>').text(v['message']).appendTo(cList);
                        });
                        $('#error-box p').append(cList).parent().show();
                    }
                    else{
                        window.location = '<?php echo site_url('/wkf/start?kode_wkf=5&referer_url=/vendor/view&kode_vendor=') . $this->session->userdata('user_id') ?>';
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