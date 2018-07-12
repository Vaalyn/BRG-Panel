<!DOCTYPE html>
<html>
	<head>
		<base href="<?php echo $data['request']->getUri()->getBasePath(); ?>/" target="_self">

		<title><?php echo htmlentities(isset($pageTitle) ? $pageTitle . ' - BRG-Panel' : 'BRG-Panel'); ?></title>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

		<link href="css/materialize.min.css" rel="stylesheet">
		<link href="css/color.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
	</head>

	<body class="grey darken-4">
		<?php include_once(__DIR__ . '/../navbar/navbar.php'); ?>
