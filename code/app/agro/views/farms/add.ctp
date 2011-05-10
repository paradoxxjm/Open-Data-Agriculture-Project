<div class="farms form">
<?php echo $this->Form->create('Farm');?>
	<fieldset>
 		<legend><?php __('Add Farm'); ?></legend>
	<?php
		echo $this->Form->input('FarmerID');
		echo $this->Form->input('Property_ID');
		echo $this->Form->input('Parish');
		echo $this->Form->input('Extension');
		echo $this->Form->input('District');
		echo $this->Form->input('Farmersize');
		echo $this->Form->input('PropertySize');
		echo $this->Form->input('Xcoord');
		echo $this->Form->input('Ycoord');
		echo $this->Form->input('FIrstnameX');
		echo $this->Form->input('LastnameX');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Farms', true), array('action' => 'index'));?></li>
	</ul>
</div>