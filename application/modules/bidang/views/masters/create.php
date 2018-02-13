<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading">Please fix the following errors:</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($bidang))
{
	$bidang = (array) $bidang;
}
$id = isset($bidang['id']) ? $bidang['id'] : '';

?>
<div class="admin-box">
	 
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('bidang') ? 'error' : ''; ?>">
				<?php echo form_label('Nama Bidang'. lang('bf_form_label_required'), 'bidang_bidang', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='bidang_bidang' type='text' name='bidang_bidang' maxlength="100" value="<?php echo set_value('bidang_bidang', isset($bidang['bidang']) ? $bidang['bidang'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('bidang'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kabid') ? 'error' : ''; ?>">
				<?php echo form_label('Kabid'. lang('bf_form_label_required'), 'bidang_kabid', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="bidang_kabid" id="bidang_kabid" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($bidang['kabid']))  echo  ($user->id==$bidang['kabid']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('kabid'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bidang_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/bidang', lang('bidang_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>