 
	<div class="control-group <?php echo form_error('pangkat') ? 'error' : ''; ?>">
		<?php echo form_label('Pangkat', 'nip', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<?php echo $pangkat; ?>
			<span class='help-inline'><?php echo form_error('pangkat'); ?></span>
		</div>
	</div>
	 
	<div class="control-group <?php echo form_error('jabatan') ? 'error' : ''; ?>">
		<?php echo form_label('Jabatan', 'jabatan', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<?php echo $jabatan; ?>
			<span class='help-inline'><?php echo form_error('jabatan'); ?></span>
		</div>
	</div>
	 