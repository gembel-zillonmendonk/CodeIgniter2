<p>
    <a href="<?php echo site_url('/workflowTest/run'); ?>">create</a>
</p>
<table>
    <tr>
        <th>wkf id</th>
        <th>node id</th>
        <th>start date</th>
        <th>end date</th>
        <th>parameters</th>
        <th>action</th>
    </tr>
    
    <?php foreach($active as $v): ?>
    <tr>
        <td><?php echo $v['WKF_ID']; ?></td>
        <td><?php echo $v['NODE_ID']; ?></td>
        <td><?php echo $v['START_DATE']; ?></td>
        <td><?php echo $v['END_DATE']; ?></td>
        <td><?php echo $v['PARAMETERS']; ?></td>
        <td><a href='<?php echo site_url('/workflowTest/run?instance_id='.$v['ID']); ?>'>run</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<table>
    <tr>
        <th>wkf id</th>
        <th>node id</th>
        <th>start date</th>
        <th>end date</th>
        <th>parameters</th>
        <th>action</th>
    </tr>
    
    <?php foreach($finish as $v): ?>
    <tr>
        <td><?php echo $v['WKF_ID']; ?></td>
        <td><?php echo $v['NODE_ID']; ?></td>
        <td><?php echo $v['START_DATE']; ?></td>
        <td><?php echo $v['END_DATE']; ?></td>
        <td><?php echo $v['PARAMETERS']; ?></td>
        <td><a href='<?php echo site_url('/workflowTest/view?instance_id='.$v['ID']); ?>'>view</a></td>
    </tr>
    <?php endforeach; ?>
</table>