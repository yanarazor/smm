<?php echo theme_view('_header'); ?>
 
<style>body { background: #f5f5f5; }</style>
<div id="wrapper"> <!-- Start of Main Container -->
  		 
    <?php
        echo isset($content) ? $content : Template::content();
    ?>
 