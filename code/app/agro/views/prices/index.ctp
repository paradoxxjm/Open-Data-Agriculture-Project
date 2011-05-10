<div class="prices index">
	<h2><?php __('Prices');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Parish');?></th>
			<th><?php echo $this->Paginator->sort('CropType');?></th>
			<th><?php echo $this->Paginator->sort('LowerPrice');?></th>
			<th><?php echo $this->Paginator->sort('UpperPrice');?></th>
			<th><?php echo $this->Paginator->sort('FreqPrice');?></th>
			<th><?php echo $this->Paginator->sort('SupplyStatus');?></th>
			<th><?php echo $this->Paginator->sort('Quality');?></th>
			<th><?php echo $this->Paginator->sort('Price_Month');?></th>
			<th><?php echo $this->Paginator->sort('Xcoord');?></th>
			<th><?php echo $this->Paginator->sort('Ycoord');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($prices as $price):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $price['Price']['Parish']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['CropType']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['LowerPrice']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['UpperPrice']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['FreqPrice']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['SupplyStatus']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['Quality']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['Price_Month']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['Xcoord']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['Ycoord']; ?>&nbsp;</td>
		<td><?php echo $price['Price']['id']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $price['Price']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $price['Price']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $price['Price']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $price['Price']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Price', true), array('action' => 'add')); ?></li>
	</ul>
</div>