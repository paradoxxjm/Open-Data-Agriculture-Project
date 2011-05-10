<div class="crops form">
<?php echo $this->Form->create('Crop');?>
	<fieldset>
 		<legend><?php __('Add Crop'); ?></legend>
	<?php
		echo $this->Form->input('Parish');
		echo $this->Form->input('Extension');
		echo $this->Form->input('District');
		echo $this->Form->input('Group');
		echo $this->Form->input('CropGroup');
		echo $this->Form->input('CropType');
		echo $this->Form->input('Property_ID');
		echo $this->Form->input('FarmerID');
		echo $this->Form->input('PropertySize');
		echo $this->Form->input('CropArea');
		echo $this->Form->input('CropCount');
		echo $this->Form->input('Crop_Date');
		echo $this->Form->input('Farmsize');
		echo $this->Form->input('FarmerAge');
		echo $this->Form->input('Xcoord');
		echo $this->Form->input('Ycoord');
		echo $this->Form->input('firstnameX');
		echo $this->Form->input('lastnameX');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Crops', true), array('action' => 'index'));?></li>
	</ul>
</div>