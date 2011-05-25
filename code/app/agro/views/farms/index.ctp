<div class="farms <!--index-->">
	<h2><?php __('Farms');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('FarmerID');?></th>
			<th><?php echo $this->Paginator->sort('PropertyID');?></th>
			<th><?php echo $this->Paginator->sort('Parish');?></th>
			<th><?php echo $this->Paginator->sort('Extension');?></th>
			<th><?php echo $this->Paginator->sort('District');?></th>
			<th><?php echo $this->Paginator->sort('Farmersize');?></th>
			<th><?php echo $this->Paginator->sort('PropertySize');?></th>
			<th><?php echo $this->Paginator->sort('Xcoord');?></th>
			<th><?php echo $this->Paginator->sort('Ycoord');?></th>
<!--			<th><?php echo $this->Paginator->sort('firstname');?></th>
			<th><?php echo $this->Paginator->sort('lastname');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>-->
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($farms as $farm):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $farm['Farm']['FarmerID']; ?>&nbsp;</td>
		<td><?php echo $farm['Farm']['PropertyID']; ?>&nbsp;</td>
		<td><?php echo $farm['Farm']['Parish']; ?>&nbsp;</td>
		<td><?php echo $farm['Farm']['Extension']; ?>&nbsp;</td>
		<td><?php echo $farm['Farm']['District']; ?>&nbsp;</td>
		<td><?php echo $farm['Farm']['Farmersize']; ?>&nbsp;</td>
		<td><?php echo $farm['Farm']['PropertySize']; ?>&nbsp;</td>
		<td><?php echo $farm['Farm']['Xcoord']; ?>&nbsp;</td>
		<td><?php echo $farm['Farm']['Ycoord']; ?>&nbsp;</td>
<!--		<td><?php echo $farm['Farm']['firstname']; ?>&nbsp;</td>
		<td><?php echo $farm['Farm']['lastname']; ?>&nbsp;</td>>
		<td><?php echo $farm['Farm']['id']; ?>&nbsp;</td>-->
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $farm['Farm']['id'])); ?>
		<!--	<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $farm['Farm']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $farm['Farm']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $farm['Farm']['id'])); ?> -->
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
        <?php echo print_r($this->passedArgs) ?>
        <?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<!--<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Farm', true), array('action' => 'add')); ?></li>
	</ul>
</div>-->
