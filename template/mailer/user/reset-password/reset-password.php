<?php include_once(__DIR__ . '/../../header.php'); ?>
	<p>
		<?php
			echo sprintf(
				'%s: <a href="%s">Passwort zurücksetzen</a>',
				'Öffne die folgende Seite um dein Passwort zurückzusetzen',
				$passwordResetUrl
			);
		?>
	</p>

	<p>
		Der Link ist für 6 Stunden gültig. Nach Ablauf dieser Zeit musst du einen neuen anfordern.
	</p>
<?php include_once(__DIR__ . '/../../footer.php'); ?>
