<div class="prices form">
<?php echo $this->Form->create('Price');?>
	<fieldset>
 		<legend><?php __('Edit Price'); ?></legend>
	<?php
		echo $this->Form->input('Parish');
		echo $this->Form->input('CropType');
		echo $this->Form->input('LowerPrice');
		echo $this->Form->input('UpperPrice');
		echo $this->Form->input('FreqPrice');
		echo $this->Form->input('SupplyStatus');
		echo $this->Form->input('Quality');
		echo $this->Form->input('Price_Month');
		echo $this->Form->input('Xcoord');
		echo $this->Form->input('Ycoord');
		echo $this->Form->input('id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Price.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Price.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Prices', true), array('action' => 'index'));?></li>
	</ul>
</div>