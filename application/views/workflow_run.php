<pre>
<?php print_r($history); ?>
<?php print_r($parameters); ?>
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

<form action="<?php site_url('/workflow/run'); ?>" method="POST">
    <?php 
    foreach ($parameters as $k=> $v) {
        echo $k;
        echo "<input type='$v' name='$k' /><br/>";
    }; ?>
    <input type="hidden" name="instance_id" value="<?php echo $instance['ID']; ?>"/>
    <input type="hidden" name="node_from" value="<?php echo $instance['NODE_ID']; ?>"/>
    <p>
        Action

        <select name="transition_id">
            <?php foreach ($transitions as $v): ?>
                <option value="<?php echo $v['ID']; ?>"><?php echo $v['NAME']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>

    <p><input type="submit" ></p>
</form>