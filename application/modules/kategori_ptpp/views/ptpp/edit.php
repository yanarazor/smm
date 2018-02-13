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

if (isset($kategori_ptpp))
{
	$kategori_ptpp = (array) $kategori_ptpp;
}
$id = isset($kategori_ptpp['id']) ? $kategori_ptpp['id'] : '';

?>
<div class="admin-box">
	 <br>
	 <br>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('kategori') ? 'error' : ''; ?>">
				<?php echo form_label('Kategori'. lang('bf_form_label_required'), 'kategori_ptpp_kategori', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='kategori_ptpp_kategori' type='text' name='kategori_ptpp_kategori' maxlength="20" value="<?php echo set_value('kategori_ptpp_kategori', isset($kategori_ptpp['kategori']) ? $kategori_ptpp['kategori'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('kategori'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('kategori_ptpp_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/ptpp/kategori_ptpp', lang('kategori_ptpp_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Kategori_Ptpp.Ptpp.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('kategori_ptpp_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('kategori_ptpp_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>