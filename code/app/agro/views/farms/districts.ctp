<?php
/**
 * Districts.ctp
 * 
 * @
 *
 * @bug Calculating incorrect paginotor count
 */
?>

<div class="parishes">
	<h2><?php __('Parishes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Parish');?></th>
			<th><?php echo $this->Paginator->sort('Extension');?></th>
			<th><?php echo $this->Paginator->sort('District');?></th>
			<th><?php echo $this->Paginator->sort('districtCount');?></th>
			<th><?php echo $this->Paginator->sort('propertySum');?></th>
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
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
    ?>	
    </p>
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>

</div>
<!-- Commented out generated code
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Parish', true), array('action' => 'add')); ?></li>
	</ul>
</div>
-->
