<!--Commented out boilerplate code: <div class="parishs index">-->
<div class="parishes">
	<h2><?php __('Parishes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Parish</th>
			<th>Extensions</th>
			<th>Districts</th>
			<th>Farm Count</th>
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
		<td><?php echo $parish['Farm']['Extension']; ?>&nbsp;</td>
		<td><?php echo $parish['Farm']['District']; ?>&nbsp;</td>
		<td><?php echo $parish['Farm']['districtCount']; ?>&nbsp;</td>
		<td><?php echo $parish['Farm']['propertySum']; ?>&nbsp;</td>
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
