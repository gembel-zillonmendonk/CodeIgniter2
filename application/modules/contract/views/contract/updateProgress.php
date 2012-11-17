<?php
$params = '';
if (count($_REQUEST) > 0) {
    foreach ($_REQUEST as $key => $value) {
        $params .= $key . '=' . $value . '&';
    }

    if (strlen($params) > 0)
        $params = '?' . $params;
}
?>

<div class="accordion">
    <h3 href="<?php echo site_url('/contract/grid_form/contract.ep_ktr_jangka_perkembangan') . $params ?>">DETAIL PROGRESS YANG DIAJUKAN</h3>
    <div></div>
    <h3 href="<?php echo site_url('/contract/view_form/contract.ep_ktr_jangka_kontrak') . $params ?>">DETAIL PROGRESS MILESTONE</h3>
    <div></div>
    <p>
        <button type="button" id="selesai">Lanjutkan Proses</button>
    </p>
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
    
    $(document).ready(function(){
//        $('#selesai').live('click', function(){
//            var params = '<?php echo str_replace('?', '', $params); ?>';
//            
//            if(params.length > 0)
//                window.location = '<?php echo site_url('/wkf/start?kode_wkf=61&referer_url=/contract/index&') ?>' + params;
//        });
        $('#selesai').live('click', function(){
            var params = '<?php echo str_replace('?', '', strtolower($params)); ?>';
            if(params.length > 0){
                $.ajax({
                    url:'<?php echo site_url('/contract/update_progress_validation') . $params ?>', 
                    success:function(responseText, textStatus, XMLHttpRequest) {
                        if(jQuery.parseJSON(responseText)){
                            var cList = $('<ul></ul>');
                            $.each(jQuery.parseJSON(responseText)['errors'], function(i, v){
                                $('<li></li>').text(v['message']).appendTo(cList);
                            });
                            $('#error-box p').append(cList).parent().show();
                        }
                        else{
                            window.location = '<?php echo site_url('/wkf/start?kode_wkf=61&referer_url=/contract/index&') ?>' + params;
                        }
                    }
                });
            }
        });
    });
</script>