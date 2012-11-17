<pre>
    <?php print_r($history); ?>
    <?php print_r($parameters); ?>
    <?php print_r($constraints); ?>
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
</pre>
<div id="node-constraints">
    <?php
    foreach ($constraints as $k=>$v) {
        switch ($v['TIPE']) {
            case 'php'  :
                eval($v['KONTEKS']);
                break;
            case 'ui'   :
                ?>
                    <div class='form-<?php echo $k;?>'></div>
                    <script>
                        $('.form-<?php echo $k;?>').load('<?php echo site_url($v['KONTEKS']); ?>');
                    </script>
                <?php
                break;
        }
    }
    ?>
</div>
<form action="<?php site_url('/workflow/run'); ?>" method="POST">
    <?php
    foreach ($parameters as $k => $v) {
        echo $k;
        echo "<input type='$v' name='$k' /><br/>";
    };
    ?>
    <input type="hidden" name="kode_proses" value="<?php echo $instance['KODE_PROSES']; ?>"/>
    <input type="hidden" name="proses_asal" value="<?php echo $instance['KODE_AKTIFITAS']; ?>"/>
    <p>
        Action

        <select name="kode_transisi">
            <?php foreach ($transitions as $v): ?>
                <option value="<?php echo $v['KODE_TRANSISI']; ?>"><?php echo $v['NAMA_TRANSISI']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        Catatan

        <textarea name="catatan" ></textarea>
    </p>
    <p><button>Proses</button></p>
</form>