<!--?php print_r($crops); ?-->
<h1>Crops</h1>
<table>
	<tr>
		<th>Crop Group</th>
		<th>Crop Type</th>
		<th>Crop Count</th>
        
	</tr>

	<?php foreach ($crops as $crop): ?>
	<tr>
		<td><?php echo $crop['Crop']['CropGroup']; ?></td>
		<td><?php echo $crop['Crop']['CropType']; ?></td>
		<td><?php echo $crop[0]['COUNT(`Crop`.`PropertyID`)']; ?></td>
	</tr>
    <?php endforeach; ?>

    <!-- Shows the page numbers -->
    <?php echo $this->Paginator->numbers(); ?>
    <!-- Shows the next and previous links -->
    <?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?> 
    <!-- prints X of Y, where X is current page and Y is number of pages -->
    <?php echo $this->Paginator->counter(); ?>

</table>
