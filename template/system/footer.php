		<script>
			let brgPlayerBaseUrl = '<?php echo $request->getUri()->getBasePath(); ?>';
			let requestSystemActive = <?php echo $systems['request']['active']; ?>;
			let messageSystemActive = <?php echo $systems['message']['active']; ?>;
			let requestAutoDjSystemActive = <?php echo $systems['autodj_request']['active']; ?>;
		</script>
		<script src="js/jquery.min.js"></script>
		<script src="js/materialize.min.js"></script>
		<script src="js/system.js"></script>
	</body>
</html>
