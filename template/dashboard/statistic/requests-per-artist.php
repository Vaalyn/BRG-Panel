<?php include(__DIR__ . '/../pagination.php'); ?>

<table class="bordered striped">
	<thead class="color-1">
		<tr>
			<th>Artist</th>
			<th>Anzahl</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($requests as $request) : ?>
			<tr>
				<td><?php echo htmlentities($request->artist); ?></td>
				<td><?php echo $request->total; ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if (!count($requests)) : ?>
			<tr>
				<td colspan="7">
					<div class="center">Es sind keine Requests vorhanden</div>
				</td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

<?php include(__DIR__ . '/../pagination.php'); ?>
