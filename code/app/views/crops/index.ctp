<div class="crops index">
	<h2><?php __('Crops');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Parish');?></th>
			<th><?php echo $this->Paginator->sort('Extension');?></th>
			<th><?php echo $this->Paginator->sort('District');?></th>
			<th><?php echo $this->Paginator->sort('Group');?></th>
			<th><?php echo $this->Paginator->sort('CropGroup');?></th>
			<th><?php echo $this->Paginator->sort('CropType');?></th>
			<th><?php echo $this->Paginator->sort('Property_ID');?></th>
			<th><?php echo $this->Paginator->sort('FarmerID');?></th>
			<th><?php echo $this->Paginator->sort('PropertySize');?></th>
			<th><?php echo $this->Paginator->sort('CropArea');?></th>
			<th><?php echo $this->Paginator->sort('CropCount');?></th>
			<th><?php echo $this->Paginator->sort('Crop_Date');?></th>
			<th><?php echo $this->Paginator->sort('Farmsize');?></th>
			<th><?php echo $this->Paginator->sort('FarmerAge');?></th>
			<th><?php echo $this->Paginator->sort('Xcoord');?></th>
			<th><?php echo $this->Paginator->sort('Ycoord');?></th>
			<th><?php echo $this->Paginator->sort('firstnameX');?></th>
			<th><?php echo $this->Paginator->sort('lastnameX');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th class="actions"><?php __('Actions');?></th>
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
		<td><?php echo $crop['Crop']['Parish']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['Extension']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['District']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['Group']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['CropGroup']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['CropType']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['Property_ID']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['FarmerID']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['PropertySize']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['CropArea']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['CropCount']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['Crop_Date']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['Farmsize']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['FarmerAge']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['Xcoord']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['Ycoord']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['firstnameX']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['lastnameX']; ?>&nbsp;</td>
		<td><?php echo $crop['Crop']['id']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $crop['Crop']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $crop['Crop']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $crop['Crop']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $crop['Crop']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Crop', true), array('action' => 'add')); ?></li>
	</ul>
</div>