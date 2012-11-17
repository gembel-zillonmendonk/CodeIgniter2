<div class="accordion">
    <h3 href="#">KOMENTAR</h3>
    <div>
        <form method="POST">
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <label for="id_catatan" class="control-label">KOMENTAR</label>
                        <div class="controls">
                            <textarea name="catatan" id="id_catatan" label="CATATAN" rows="5" cols="200" class="{validate:{required:true}}"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="id_kode_transisi" class="control-label">RESPON</label>                
                        <div class="controls">
                            <select id="id_kode_transisi" name="kode_transisi" class=" {validate:{required:true}}">
                                <?php foreach ($transitions as $v): ?>
                                    <option value="<?php echo $v['KODE_TRANSISI']; ?>"><?php echo $v['NAMA_TRANSISI']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>


                </div>
            </div>
            <?php
//                    foreach ($parameters as $k => $v) {
//                        echo $k;
//                        echo "<input type='$v' name='$k' /><br/>";
//                    };
            ?>
            <input type="hidden" name="kode_wkf" value="<?php echo $kode_wkf; ?>"/>
            <button>Proses</button>    
        </form>

    </div>
</div>
<script>    
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