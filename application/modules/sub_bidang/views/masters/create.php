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

if (isset($sub_bidang))
{
	$sub_bidang = (array) $sub_bidang;
}
$id = isset($sub_bidang['id']) ? $sub_bidang['id'] : '';

?>
<div class="admin-box">
	<h3>Sub Bidang</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('sub_bidang_nama_subbid') ? 'error' : ''; ?>">
				<?php echo form_label('Nama Sub Bid'. lang('bf_form_label_required'), 'sub_bidang_nama_subbid', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='sub_bidang_nama_subbid' type='text' name='sub_bidang_nama_subbid' maxlength="50" value="<?php echo set_value('sub_bidang_nama_subbid', isset($sub_bidang['nama_subbid']) ? $sub_bidang['nama_subbid'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('sub_bidang_nama_subbid'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('sub_bidang_kasubid') ? 'error' : ''; ?>">
				<?php echo form_label('Kasubid', 'sub_bidang_kasubid', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="sub_bidang_kasubid" id="sub_bidang_kasubid" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($sub_bidang['kasubid']))  echo  ($user->id==$sub_bidang['kasubid']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sub_bidang_kasubid'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('sub_bidang_id_bidang') ? 'error' : ''; ?>">
				<?php echo form_label('Bidang', 'sub_bidang_id_bidang', array('class' => 'control-label') ); ?>
				<div class='controls'>
					
					<select name="sub_bidang_id_bidang" id="sub_bidang_id_bidang" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($sub_bidang['id_bidang']))  echo  ($bidang->id==$sub_bidang['id_bidang']) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('sub_bidang_id_bidang'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('sub_bidang_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/masters/sub_bidang', lang('sub_bidang_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>