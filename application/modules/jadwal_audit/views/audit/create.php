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

if (isset($jadwal_audit))
{
	$jadwal_audit = (array) $jadwal_audit;
}
$id = isset($jadwal_audit['id']) ? $jadwal_audit['id'] : '';

?>
<div class="admin-box">
	<h3>Jadwal Audit</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('jadwal_audit_id_audit') ? 'error' : ''; ?>">
				<?php echo form_label('Audit'. lang('bf_form_label_required'), 'jadwal_audit_id_audit', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="jadwal_audit_id_audit" id="jadwal_audit_id_audit" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($audit_internals) && is_array($audit_internals) && count($audit_internals)):?>
						<?php foreach($audit_internals as $audit_internal):?>
							<option value="<?php echo $audit_internal->id?>" <?php if(isset($jadwal_audit['id_audit']))  echo  ($audit_internal->id==$jadwal_audit['id_audit']) ? "selected" : ""; ?>> <?php e(ucfirst($audit_internal->judul)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('jadwal_audit_id_audit'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('jadwal_audit_id_bidang') ? 'error' : ''; ?>">
				<?php echo form_label('Bidang'. lang('bf_form_label_required'), 'jadwal_audit_id_bidang', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="jadwal_audit_id_bidang" id="jadwal_audit_id_bidang" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
						<?php foreach($bidangs as $bidang):?>
							<option value="<?php echo $bidang->id?>" <?php if(isset($jadwal_audit['id_bidang']))  echo  ($bidang->id==$jadwal_audit['id_bidang']) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('jadwal_audit_id_bidang'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('pm') ? 'error' : ''; ?>">
				<?php echo form_label('PM'. lang('bf_form_label_required'), 'jadwal_audit_pm', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='jadwal_audit_pm' type='text' name='jadwal_audit_pm'  value="<?php echo set_value('jadwal_audit_pm', isset($jadwal_audit['pm']) ? $jadwal_audit['pm'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('pm'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('klausul') ? 'error' : ''; ?>">
				<?php echo form_label('Klausul', 'jadwal_audit_klausul', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='jadwal_audit_klausul' type='text' name='jadwal_audit_klausul'  value="<?php echo set_value('jadwal_audit_klausul', isset($jadwal_audit['klausul']) ? $jadwal_audit['klausul'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('klausul'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tanggal') ? 'error' : ''; ?>">
				<?php echo form_label('Tanggal', 'jadwal_audit_tanggal', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='jadwal_audit_tanggal' type='text' name='jadwal_audit_tanggal'  value="<?php echo set_value('jadwal_audit_tanggal', isset($jadwal_audit['tanggal']) ? $jadwal_audit['tanggal'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tanggal'); ?></span>
				</div>
			</div>
            <div class="control-group <?php echo form_error('jadwal_audit_auditor_kepala') ? 'error' : ''; ?>">
				<?php echo form_label('Auditor Kepala', 'daftar_induk_dokumen_pembuat', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="jadwal_audit_auditor_kepala" id="jadwal_audit_auditor_kepala" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($jadwal_audit['auditor_kepala']))  echo  ($user->id==$jadwal_audit['auditor_kepala']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('jadwal_audit_auditor_kepala'); ?></span>
				</div>
			</div>
            <div class="control-group <?php echo form_error('jadwal_audit_auditor') ? 'error' : ''; ?>">
				<?php echo form_label('Auditor', 'jadwal_audit_auditor', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="jadwal_audit_auditor" id="jadwal_audit_auditor" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($users) && is_array($users) && count($users)):?>
						<?php foreach($users as $user):?>
							<option value="<?php echo $user->id?>" <?php if(isset($jadwal_audit['auditor']))  echo  ($user->id==$jadwal_audit['auditor']) ? "selected" : ""; ?>> <?php e(ucfirst($user->display_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
					<span class='help-inline'><?php echo form_error('jadwal_audit_auditor'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('jadwal_audit_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/audit/jadwal_audit', lang('jadwal_audit_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>