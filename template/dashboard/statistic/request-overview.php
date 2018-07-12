<?php include(__DIR__ . '/../pagination.php'); ?>

<table class="bordered striped">
	<thead class="color-1">
		<tr>
			<th>Id</th>
			<th>Titel</th>
			<th>Artist</th>
			<th>Nickname</th>
			<th>Zeitpunkt</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($requests as $request) : ?>
			<tr>
				<td><?php echo $request->request_id; ?></td>
				<td><?php echo htmlentities($request->title); ?></td>
				<td><?php echo htmlentities($request->artist); ?></td>
				<td><?php echo htmlentities($request->nickname); ?></td>
				<td><?php echo $request->created_at->format('H:i:s - d.m.Y'); ?></td>
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
