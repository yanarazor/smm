<?php
	$this->load->library('convert');
	$convert = new convert();
?>
 

</div> <!-- boxed -->
</div> <!-- sb-site --> 
<?php echo Assets::js(); ?>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script> 
<div id="back-top" style="display: none;">
    <a href="#header"><i class="fa fa-chevron-up"></i></a>
</div>

<!-- This would be a good place to use a CDN version of jQueryUI if needed -->
</body>

</html>