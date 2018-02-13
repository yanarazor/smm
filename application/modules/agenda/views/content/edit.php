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

if (isset($agenda))
{
	$agenda = (array) $agenda;
}
$id = isset($agenda['id']) ? $agenda['id'] : '';

?>
<div class="admin-box">
	<h3>agenda</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('dari') ? 'error' : ''; ?>">
				<?php echo form_label('Dari Tanggal', 'agenda_dari', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='agenda_dari' type='text' name='agenda_dari'  value="<?php echo set_value('agenda_dari', isset($agenda['dari']) ? $agenda['dari'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('dari'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('sampai') ? 'error' : ''; ?>">
				<?php echo form_label('Sampai Tanggal', 'agenda_sampai', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='agenda_sampai' type='text' name='agenda_sampai'  value="<?php echo set_value('agenda_sampai', isset($agenda['sampai']) ? $agenda['sampai'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('sampai'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kategori') ? 'error' : ''; ?>">
				<?php echo form_label('Kategori', 'agenda_kategori', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='agenda_kategori' type='text' name='agenda_kategori' maxlength="50" value="<?php echo set_value('agenda_kategori', isset($agenda['kategori']) ? $agenda['kategori'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kategori'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('tempat') ? 'error' : ''; ?>">
				<?php echo form_label('Tempat', 'agenda_tempat', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='agenda_tempat' type='text' name='agenda_tempat' maxlength="255" value="<?php echo set_value('agenda_tempat', isset($agenda['tempat']) ? $agenda['tempat'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('tempat'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('kegiatan') ? 'error' : ''; ?>">
				<?php echo form_label('Kegiatan', 'agenda_kegiatan', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='agenda_kegiatan' type='text' name='agenda_kegiatan'  value="<?php echo set_value('agenda_kegiatan', isset($agenda['kegiatan']) ? $agenda['kegiatan'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kegiatan'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('agenda_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/agenda', lang('agenda_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Agenda.Content.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('agenda_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('agenda_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>