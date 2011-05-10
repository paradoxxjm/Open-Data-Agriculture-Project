<h1>Parishes</h1>
<table>
	<tr>
        <th>Parish</th>
        <th>Farm Count</th>
        <th>Property Sum</th>
    </tr>
	<?php foreach ($parishes as $parish): ?>
    <tr>
		<td><?php echo $parish['Farm']['Parish']; ?></td>
		<td><?php echo $parish['Farm']['FarmCount']; ?></td>
		<td><?php echo $parish['Farm']['PropertySum']; ?></td>
        <td></td>
    </tr>
    <?php endforeach; ?>
</table>
