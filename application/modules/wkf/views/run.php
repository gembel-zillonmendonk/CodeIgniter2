<!--<pre>
    <?php //print_r($history); ?>
    <?php //print_r($parameters); ?>
    <?php //print_r($constraints); ?>
    <?php
//$f = create_function('$a,$b', 'return (($a>$b) ? true : false);');
//echo  ( $f(4,2) ); //will return true
//$param = json_decode('{"a":"6","b":"5"}', true);
//$var = '';
//foreach ($param as $k => $v) {
//    $var .= '$'.$k.' = "'. $v .'"; ';
//}
//
//$condition = '$a > $b';
//$condition = 'if(' .$condition. ') return true; else return false;';
//
//echo $var . $condition;
//
//$return = eval($var . $condition);
//
//echo $return;
    ?>
</pre>-->
<div id="node-constraints">
    <?php
    foreach ($constraints as $k => $v) {
        switch ($v['TIPE']) {
            case 'php' :
                eval($v['KONTEKS']);
                break;
            case 'ui' :
                ?>
                <div class='wkf-form' id='form-<?php echo $k; ?>'></div>
                <script>
                    $('#form-<?php echo $k; ?>').load('<?php echo site_url($v['KONTEKS']); ?>');
                </script>
                <?php
                break;
        }
    }
    ?>
</div>
<br/>
<div class="tabs">
    <ul>
        <li><a href="#tabs-komentar">ACTION</a></li>
        <li><a href="#tabs-history">DAFTAR KOMENTAR</a></li>
    </ul>
    <div id="tabs-komentar">
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
                    <input type="hidden" name="kode_proses" value="<?php echo $instance['KODE_PROSES']; ?>"/>
                    <input type="hidden" name="proses_asal" value="<?php echo $instance['KODE_AKTIFITAS']; ?>"/>
                    <button>Proses</button>    
                </form>

            </div>
        </div>
    </div>

    <div id="tabs-history">
        <div class="accordion">
            <h3 href="#">HISTORY KOMENTAR</h3>
            <div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <?php
                            $cols = $history[0];
                            $col_cnt = count($history);
                            foreach ($cols as $key => $val) :
                                ?>
                                <th>
                                    <?php echo $key; ?>
                                </th>

                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $key => $val) : ?>
                            <tr>
                                <td>
                                    <?php echo++$key; ?>
                                </td>
                                <?php foreach ($val as $k => $v) : ?>
                                    <td>
                                        <?php echo $v; ?>
                                    </td>
                                <?php endforeach; ?>                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>    
    $('.tabs').tabs();
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