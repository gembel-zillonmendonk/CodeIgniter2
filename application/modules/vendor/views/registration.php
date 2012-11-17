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
        
    $(document).ready(function(){
        
        // event for verifikasi object per page
        $('#selanjutnya').live('click', function(){
            $.ajax({
                url:'<?php echo site_url('/vendor/registration') ?>', 
                success:function(responseText, textStatus, XMLHttpRequest) {
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