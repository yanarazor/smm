<?php

$errorClass = ' error';
$controlClass = 'span6';
$fieldData = array(
    'errorClass'    => $errorClass,
    'controlClass'  => $controlClass,
);

if (isset($user) && $user->banned) :
?>
<div class="alert alert-warning fade in">
	<h4 class="alert-heading"><?php echo lang('us_banned_admin_note'); ?></h4>
</div>
<?php
endif;
if (isset($password_hints) ) :
?>
<div class="alert alert-info fade in">
    <a data-dismiss="alert" class="close">&times;</a>
    <?php echo $password_hints; ?>
</div>
<?php
endif;

echo form_open($this->uri->uri_string(), 'class="form-horizontal" autocomplete="off"');
?>
	<fieldset>
		<legend><?php echo lang('us_account_details') ?></legend>
        <?php Template::block('user_fields', 'user_fields', $fieldData); ?>
	</fieldset>
	<?php
    if (has_permission('Bonfire.Roles.Manage')
        && ( ! isset($user) || (isset($user) && has_permission('Permissions.' . $user->role_name . '.Manage')))
       ) :
    ?>
    <fieldset>
        <legend><?php echo lang('us_role'); ?></legend>
        <div class="control-group">
            <label for="role_id" class="control-label"><?php echo lang('us_role'); ?></label>
            <div class="controls">
                <select name="role_id" id="role_id" class="chzn-select <?php echo $controlClass; ?>">
                    <?php
                    if (isset($roles) && is_array($roles) && count($roles)) :
                        foreach ($roles as $role) :
                            if (has_permission('Permissions.' . ucfirst($role->role_name) . '.Manage')) :
                                // check if it should be the default
                                $default_role = false;
                                if ((isset($user) && $user->role_id == $role->role_id)
                                    || ( ! isset($user) && $role->default == 1)
                                   ) {
                                    $default_role = true;
                                }
                    ?>
                    <option value="<?php echo $role->role_id; ?>" <?php echo set_select('role_id', $role->role_id, $default_role); ?>>
                        <?php e(ucfirst($role->role_name)); ?>
                    </option>
                    <?php
                            endif;
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
        </div>
    </fieldset>
    <div class="control-group <?php echo form_error('nip') ? 'error' : ''; ?>">
		<?php echo form_label('Nip', 'nip', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<input class="<?php echo $controlClass; ?>" type="text" id="nip" name="nip" value="<?php echo set_value('nip', isset($user->nip) ? $user->nip : ''); ?>" />
        
			<span class='help-inline'><?php echo form_error('nip'); ?></span>
		</div>
	</div>
	<div class="control-group <?php echo form_error('pangkat') ? 'error' : ''; ?>">
		<?php echo form_label('Pangkat', 'nip', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<input class="<?php echo $controlClass; ?>" type="text" id="pangkat" name="pangkat" value="<?php echo set_value('pangkat', isset($user->nip) ? $user->pangkat : ''); ?>" />
        
			<span class='help-inline'><?php echo form_error('pangkat'); ?></span>
		</div>
	</div>
	<div class="control-group <?php echo form_error('golongan') ? 'error' : ''; ?>">
		<?php echo form_label('Golongan', 'nip', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<input class="<?php echo $controlClass; ?>" type="text" id="golongan" name="golongan" value="<?php echo set_value('golongan', isset($user->golongan) ? $user->golongan : ''); ?>" />
        
			<span class='help-inline'><?php echo form_error('golongan'); ?></span>
		</div>
	</div>
	<div class="control-group <?php echo form_error('jabatan') ? 'error' : ''; ?>">
		<?php echo form_label('Jabatan', 'jabatan', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<input class="<?php echo $controlClass; ?>" type="text" id="jabatan" name="jabatan" value="<?php echo set_value('jabatan', isset($user->jabatan) ? $user->jabatan : ''); ?>" />
        
			<span class='help-inline'><?php echo form_error('jabatan'); ?></span>
		</div>
	</div>
	<div class="control-group <?php echo form_error('atasan') ? 'error' : ''; ?>">
			<?php echo form_label('Atasan', 'atasan', array('class' => 'control-label') ); ?>
			<div class='controls'>
				<select name="atasan" id="atasan" class="chosen-select-deselect">
					<option value="">-- Pilih  --</option>
					<?php if (isset($userrecords) && is_array($userrecords) && count($userrecords)):?>
					<?php foreach($userrecords as $userrecord):?>
						<option value="<?php echo $userrecord->id?>" <?php if(isset($user->atasan))  echo  ($userrecord->id==$user->atasan) ? "selected" : ""; ?>> <?php e(ucfirst($userrecord->display_name)); ?></option>
						<?php endforeach;?>
					<?php endif;?>
				</select>
				<span class='help-inline'><?php echo form_error('atasan'); ?></span>
			</div>
	</div> 
	<div class="control-group <?php echo form_error('bidang') ? 'error' : ''; ?>">
		<?php echo form_label('Bidang', 'bidang', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<select name="bidang" id="bidang" class="chosen-select-deselect">
				<option value="">-- Pilih  --</option>
				<?php if (isset($bidangs) && is_array($bidangs) && count($bidangs)):?>
				<?php foreach($bidangs as $bidang):?>
					<option value="<?php echo $bidang->id?>" <?php if(isset($user->id_bidang))  echo  ($bidang->id==$user->id_bidang) ? "selected" : ""; ?>> <?php e(ucfirst($bidang->bidang)); ?></option>
					<?php endforeach;?>
				<?php endif;?>
			</select>
			<span class='help-inline'><?php echo form_error('bidang'); ?></span>
		</div>
	</div>
    <div class="control-group <?php echo form_error('id_subbid') ? 'error' : ''; ?>">
		<?php echo form_label('Sub Bidang', 'id_subbid', array('class' => 'control-label') ); ?>
		<div class='controls'>
			<select name="id_subbid" id="id_subbid" class="chosen-select-deselect">
				<option value="">-- Pilih  --</option>
				<?php if (isset($subbidangs) && is_array($subbidangs) && count($subbidangs)):?>
				<?php foreach($subbidangs as $subbidang):?>
					<option value="<?php echo $subbidang->id?>" <?php if(isset($user->id_subbid))  echo  ($subbidang->id==$user->id_subbid) ? "selected" : ""; ?>> <?php e(ucfirst($subbidang->nama_subbid)); ?></option>
					<?php endforeach;?>
				<?php endif;?>
			</select>
			<span class='help-inline'><?php echo form_error('id_subbid'); ?></span>
		</div>
	</div>
    <?php
    endif;

    // Allow modules to render custom fields
    Events::trigger('render_user_form');
    ?>
    <!-- Start of User Meta -->
    <?php $this->load->view('users/user_meta');?>
    <!-- End of User Meta -->
    <?php
    if (isset($user) && has_permission('Permissions.' . ucfirst($user->role_name) . '.Manage')
        && $user->id != $this->auth->user_id() && ($user->banned || $user->deleted)
       ) :
    ?>
    <fieldset>
        <legend><?php echo lang('us_account_status'); ?></legend>
        <?php
        $field = 'activate';
        if ($user->active) {
            $field = 'de' . $field;
        }
        ?>
        <div class="control-group">
            <div class="controls">
                <label for="<?php echo $field; ?>">
                    <input type="checkbox" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="1" />
                    <?php echo lang('us_' . $field . '_note') ?>
                </label>
            </div>
        </div>
        <?php if ($user->deleted) : ?>
        <div class="control-group">
            <div class="controls">
                <label for="restore">
                    <input type="checkbox" name="restore" id="restore" value="1" />
                    <?php echo lang('us_restore_note'); ?>
                </label>
            </div>
        </div>
        <?php elseif ($user->banned) : ?>
        <div class="control-group">
            <div class="controls">
                <label for="unban">
                    <input type="checkbox" name="unban" id="unban" value="1" />
                    <?php echo lang('us_unban_note'); ?>
                </label>
            </div>
        </div>
        <?php endif; ?>
    </fieldset>
    <?php endif; ?>
    <div class="form-actions">
        <input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bf_action_save') . ' ' . lang('bf_user'); ?>" />
        <?php echo lang('bf_or'); ?>
        <?php echo anchor(SITE_AREA . '/settings/users', lang('bf_action_cancel')); ?>
    </div>
<?php echo form_close(); ?>
<link href="<?php echo base_url(); ?>assets/css/chosen/chosen.css" rel="stylesheet" type="text/css" />
<script language='JavaScript' type='text/javascript' src='<?php echo base_url(); ?>assets/js/chosen/chosen.jquery.js'></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>