<!--Commented out boilerplate code: <div class="crops index">-->
<div class="cropes">
	<h2><?php __('Crops');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Crop Group</th>
			<th>Crop Types</th>
			<th>Total Property Size</th>
			<th>Average Property Size</th>
			<th>Total Crop Area</th>
			<th>Average Crop Size</th>
	</tr>
	<?php
	$i = 0;
	foreach ($crops as $crop):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $crop['Crop']['CropGroup']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['CropType']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['sumProperty']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['avgProperty']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['sumCrop']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['avgCrop']; ?>&nbsp;</td>
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
