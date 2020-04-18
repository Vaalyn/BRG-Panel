<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo $data['request']->getUri()->getBasePath(); ?>/" target="_self">

		<title>Best-of Voting - Brony Radio Germany</title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

		<link href="css/best-of-voting-button.css" rel="stylesheet">
	</head>

	<body class="grey darken-4">
		<a href="<?php echo $router->pathFor('best-of-voting'); ?>" class="btn" target="_blank">
			<img src="image/brg_logo.png" aria-hidden="true"/>
			<?php if ($isVotingActive): ?>
				Best-of Voting <?php echo $votingEndDate->locale($language)->isoFormat('MMMM'); ?>
			<?php else : ?>
				Best-of Voting <?php echo p__('best-of-voting', 'Infos'); ?>
			<?php endif; ?>
		</a>
	</body>
</html>
