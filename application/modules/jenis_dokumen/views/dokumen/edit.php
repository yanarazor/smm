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

if (isset($jenis_dokumen))
{
	$jenis_dokumen = (array) $jenis_dokumen;
}
$id = isset($jenis_dokumen['id']) ? $jenis_dokumen['id'] : '';

?>
<div class="admin-box">
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('jenis_dokumen_jenis') ? 'error' : ''; ?>">
				<?php echo form_label('Jenis'. lang('bf_form_label_required'), 'jenis_dokumen_jenis', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='jenis_dokumen_jenis' type='text' name='jenis_dokumen_jenis' maxlength="50" value="<?php echo set_value('jenis_dokumen_jenis', isset($jenis_dokumen['jenis']) ? $jenis_dokumen['jenis'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('jenis_dokumen_jenis'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('jenis_dokumen_pemeriksa') ? 'error' : ''; ?>">
				<?php echo form_label('Pemeriksa'. lang('bf_form_label_required'), 'jenis_dokumen_pemeriksa', array('class' => 'control-label') ); ?>
				<div class='controls'>
                	<select name="jenis_dokumen_pemeriksa" id="jenis_dokumen_pemeriksa" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($roles) && is_array($roles) && count($roles)):?>
						<?php foreach($roles as $role):?>
							<option value="<?php echo $role->role_id?>" <?php if(isset($jenis_dokumen['pemeriksa']))  echo  ($role->role_id==$jenis_dokumen['pemeriksa']) ? "selected" : ""; ?>> <?php e(ucfirst($role->role_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
 					<span class='help-inline'><?php echo form_error('jenis_dokumen_pemeriksa'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('jenis_dokumen_pengesah') ? 'error' : ''; ?>">
				<?php echo form_label('Pengesah'. lang('bf_form_label_required'), 'jenis_dokumen_pengesah', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<select name="jenis_dokumen_pengesah" id="jenis_dokumen_pengesah" class="chosen-select-deselect">
						<option value="">-- Pilih  --</option>
						<?php if (isset($roles) && is_array($roles) && count($roles)):?>
						<?php foreach($roles as $role):?>
							<option value="<?php echo $role->role_id?>" <?php if(isset($jenis_dokumen['pengesah']))  echo  ($role->role_id==$jenis_dokumen['pengesah']) ? "selected" : ""; ?>> <?php e(ucfirst($role->role_name)); ?></option>
							<?php endforeach;?>
						<?php endif;?>
					</select>
                    <span class='help-inline'><?php echo form_error('jenis_dokumen_pengesah'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('keterangan') ? 'error' : ''; ?>">
				<?php echo form_label('Keterangan', 'jenis_dokumen_keterangan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'jenis_dokumen_keterangan', 'id' => 'jenis_dokumen_keterangan','style'=>'width:600px', 'rows' => '5', 'cols' => '80', 'value' => set_value('jenis_dokumen_keterangan', isset($jenis_dokumen['keterangan']) ? $jenis_dokumen['keterangan'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('keterangan'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('jenis_dokumen_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/dokumen/jenis_dokumen', lang('jenis_dokumen_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">	  

$(document).ready(function() {	  
	 $('#jenis_dokumen_keterangan').wysiwyg();
});
	
	 
</script>