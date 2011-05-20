<!--Commented out boilerplate code: <div class="parishs index">-->
<div class="parishes">
	<h2><?php __('Parishes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Parish</th>
			<th>Parish Count</th>
			<th>Total Size</th>
	</tr>
	<?php
	$i = 0;
	foreach ($parishes as $parish):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $parish['Farm']['Parish']; ?>&nbsp;</td>
		<td><?php echo $parish['Farm']['parishCount']; ?>&nbsp;</td>
		<td><?php echo $parish['Farm']['totalSize']; ?>&nbsp;</td>
	</tr>
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
