<h1>Farms</h1>
<table>
	<tr>
        <th>FarmerID</th>
        <th>First name</th>
        <th>Last name</th>
	<th>Property ID</th>
        <th>Parish</th>
        <th>Extension</th>
        <th>District</th>
        <th>Farmer Size</th>
        <th>Property Size</th>
        <th>X Coord</th>
        <th>Y Coord</th>
        
	</tr>

	<?php foreach ($farms as $farm): ?>
	<tr>
		<td><?php echo $farm['Farm']['FarmerID']; ?></td>
		<td><?php echo $farm['Farm']['firstname']; ?></td>
		<td><?php echo $farm['Farm']['lastname']; ?></td>
		<td><?php echo $farm['Farm']['PropertyID']; ?></td>
		<td><?php echo $farm['Farm']['Parish']; ?></td>
		<td><?php echo $farm['Farm']['Extension']; ?></td>
		<td><?php echo $farm['Farm']['District']; ?></td>
		<td><?php echo $farm['Farm']['Farmersize']; ?></td>
		<td><?php echo $farm['Farm']['PropertySize']; ?></td>
		<td><?php echo $farm['Farm']['Xcoord']; ?></td>
		<td><?php echo $farm['Farm']['Ycoord']; ?></td>
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
