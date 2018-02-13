	<footer class="container-fluid footer">
		<p class="pull-right">
			Executed in {elapsed_time} seconds, using {memory_usage}.
			
		</p>
	</footer>

	<div id="debug"><!-- Stores the Profiler Results --></div>

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script language='JavaScript' type='text/javascript' src='<?php echo js_path();?>jquery-1.7.2.min.js'></script>
	<?php echo Assets::js(); ?>
</body>
</html>
