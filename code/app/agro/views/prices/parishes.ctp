<!--Commented out boilerplate code: <div class="parishs index">-->
<div class="parishes">
	<h2><?php __('Parishes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Parish</th>
			<th>Crop Type</th>
			<th>Average Price</th>
	</tr>
	<?php
	$i = 0;
	foreach ($parishes as $parish):
	?>
    <?php if (!empty($parish)): ?>
        <?php
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
        ?>

        <tr<?php echo $class;?>>
            <td><?php echo $parish['Price']['Parish']; ?>&nbsp;</td>
            <td><?php echo $parish['Price']['CropType']; ?>&nbsp;</td>
            <td><?php echo money_format('%.2n', $parish['Price']['avgPrice']); ?>&nbsp;</td>
        </tr>
    <?php endif; ?>
<?php endforeach; ?>
	</table>

</div>
<!-- Commented out generated code
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Parish', true), array('action' => 'add')); ?></li>
	</ul>
</div>
-->
