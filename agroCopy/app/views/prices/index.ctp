<h1>Prices</h1>
<table>
	<tr>
        <th>Parish</th>
        <th>Crop Type</th>
        <th>Lower Price</th>
        <th>Upper Price</th>
        <th>Freq Price</th>
        <th>Price Month</th>
        <th>X Coord</th>
        <th>Y Coord</th>
        
	</tr>

	<?php foreach ($prices as $price): ?>
	<tr>
		<td><?php echo $price['Price']['Parish']; ?></td>
		<td><?php echo $price['Price']['CropType']; ?></td>
		<td><?php echo $price['Price']['LowerPrice']; ?></td>
		<td><?php echo $price['Price']['UpperPrice']; ?></td>
		<td><?php echo $price['Price']['FreqPrice']; ?></td>
		<td><?php echo $price['Price']['PriceMonth']; ?></td>
		<td><?php echo $price['Price']['Xcoord']; ?></td>
		<td><?php echo $price['Price']['Ycoord']; ?></td>
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
