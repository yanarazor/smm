<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.timepicker.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.timepicker.js"></script>
<?php

$validation_errors = validation_errors();
$show_extended_settings = ! empty($extended_settings);

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;
?>
<div class="admin-box">

	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#main-settings" data-toggle="tab"><?php echo lang('set_tab_settings') ?></a>
				</li>
				<li>
					<a href="#security" data-toggle="tab"><?php echo lang('set_tab_security') ?></a>
				</li>
			<?php if (has_permission('Site.Developer.View')) : ?>
				<li>
					<a href="#developer" data-toggle="tab"><?php echo lang('set_tab_developer') ?></a>
				</li>
			<?php endif;
				if ($show_extended_settings) :
			?>
				<li>
					<a href="#extended" data-toggle="tab"><?php echo lang('set_tab_extended') ?></a>
				</li>
			<?php endif; ?>
			</ul>
			<div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
				<!-- Start of Main Settings Tab Pane -->
				<div class="tab-pane active" id="main-settings">
					<fieldset>
						<legend><?php echo lang('bf_site_information') ?></legend>

						<div class="control-group">
							<label class="control-label" for="title"><?php echo lang('bf_site_name') ?></label>
							<div class="controls">
								<input type="text" name="title" id="title" class="span6" value="<?php echo set_value('site.title', isset($settings['site.title']) ? $settings['site.title'] : '') ?>" />
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="system_email"><?php echo lang('bf_site_email') ?></label>
							<div class="controls">
								<input type="text" name="system_email" id="system_email" class="span4" value="<?php echo set_value('site.system_email', isset($settings['site.system_email']) ? $settings['site.system_email'] : '') ?>" />
								<p class="help-inline"><?php echo lang('bf_site_email_help') ?></p>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="status"><?php echo lang('bf_site_status') ?></label>
							<div class="controls">
								<select name="status" id="status">
									<option value="1" <?php echo isset($settings) && $settings['site.status'] == 1 ? 'selected="selected"' : set_select('site.status', '1') ?>><?php echo lang('bf_online') ?></option>
									<option value="0" <?php echo isset($settings) && $settings['site.status'] == 0 ? 'selected="selected"' : set_select('site.status', '1') ?>><?php echo lang('bf_offline') ?></option>
								</select>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="list_limit"><?php echo lang('bf_top_number') ?></label>
							<div class="controls">
								<input type="text" name="list_limit" id="list_limit" value="<?php echo set_value('list_limit', isset($settings['site.list_limit']) ? $settings['site.list_limit'] : '')  ?>" class="span1" />
								<p class="help-inline"><?php echo lang('bf_top_number_help') ?></p>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="languages"><?php echo lang('bf_language') ?></label>
							<div class="controls">
								<select name="languages[]" id="languages" multiple="multiple">
						<?php
							if (is_array($languages) && count($languages)) :
								foreach ($languages as $language) :
									$selected = in_array($language, $selected_languages) ? TRUE : FALSE;
						?>
									<option value="<?php e($language); ?>" <?php echo set_select('languages', $language, $selected); ?>><?php e(ucfirst($language)); ?></option>
						<?php
								endforeach;
							endif;
						?>
								</select>
								<p class="help-inline"><?php echo lang('bf_language_help') ?></p>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Setting Sistem</legend>
						<div class="control-group">
							<label class="control-label" for="list_limit">Path Upload Files</label>
							<div class="controls">
								<input type="text" name="pathuploaded" id="pathuploaded" value="<?php echo set_value('pathuploaded', isset($settings['site.pathuploaded']) ? $settings['site.pathuploaded'] : '')  ?>" class="span6" />
								<p class="help-inline">var/www/..</p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="list_limit">Url Uploaded Files</label>
							<div class="controls">
								<input type="text" name="urluploaded" id="urluploaded" value="<?php echo set_value('urluploaded', isset($settings['site.urluploaded']) ? $settings['site.urluploaded'] : '')  ?>" class="span6" />
								<p class="help-inline">http://..</p>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Setting Permintaan Barang</legend>
						<div class="control-group">
							<label class="control-label" for="title">Kode Kasubid</label>
							<div class="controls">
								<select name="kasubkpu" id="kasubkpu" class="chosen-select-deselect span4">
									<option value="">-- Silahkan Pilih  --</option>
									<?php if (isset($users) && is_array($users) && count($users)):?>
									<?php foreach($users as $rec):?>
										<option value="<?php echo $rec->id?>" <?php if(isset($settings['site.kasubkpu']))  echo  ($rec->id==$settings['site.kasubkpu']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
										<?php endforeach;?>
									<?php endif;?>
								</select>
								
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="title">Persediaan</label>
							<div class="controls">
								<select name="persediaan" id="persediaan" class="chosen-select-deselect span4">
									<option value="">-- Silahkan Pilih  --</option>
									<?php if (isset($users) && is_array($users) && count($users)):?>
									<?php foreach($users as $rec):?>
										<option value="<?php echo $rec->id?>" <?php if(isset($settings['site.persediaan']))  echo  ($rec->id==$settings['site.persediaan']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
										<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="title">Pengadaan</label>
							<div class="controls">
								<select name="pengadaan" id="pengadaan" class="chosen-select-deselect span4">
									<option value="">-- Silahkan Pilih  --</option>
									<?php if (isset($users) && is_array($users) && count($users)):?>
									<?php foreach($users as $rec):?>
										<option value="<?php echo $rec->id?>" <?php if(isset($settings['site.pengadaan']))  echo  ($rec->id==$settings['site.pengadaan']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
										<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="title">BMN</label>
							<div class="controls">
								<select name="bmn" id="bmn" class="chosen-select-deselect span4">
									<option value="">-- Silahkan Pilih  --</option>
									<?php if (isset($users) && is_array($users) && count($users)):?>
									<?php foreach($users as $rec):?>
										<option value="<?php echo $rec->id?>" <?php if(isset($settings['site.bmn']))  echo  ($rec->id==$settings['site.bmn']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
										<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="title">Bendahara Pengeluaran</label>
							<div class="controls">
								<select name="bendahara" id="bendahara" class="chosen-select-deselect span4">
									<option value="">-- Silahkan Pilih  --</option>
									<?php if (isset($users) && is_array($users) && count($users)):?>
									<?php foreach($users as $rec):?>
										<option value="<?php echo $rec->id?>" <?php if(isset($settings['site.bendahara']))  echo  ($rec->id==$settings['site.bendahara']) ? "selected" : ""; ?>> <?php e(ucfirst($rec->display_name)); ?></option>
										<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Setting Kehadiran</legend>
						<div class="control-group">
							<label class="control-label" for="title">Max Jam Masuk Kerja</label>
							<div class="controls">
								<input type="text" name="maxmasuk" id="maxmasuk"  class="timeformat span2" value="<?php echo set_value('site.maxmasuk', isset($settings['site.maxmasuk']) ? $settings['site.maxmasuk'] : '') ?>" />
								<p class="help-inline">Isi dengan maksimal jam masuk, (ex 08:30:00)</p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="title">Min Jam Pulang Kerja</label>
							<div class="controls">
								<input type="text" name="maxpulang" id="maxpulang"  class="timeformat span2" value="<?php echo set_value('site.maxmasuk', isset($settings['site.maxpulang']) ? $settings['site.maxpulang'] : '') ?>" />
								<p class="help-inline">Isi dengan minimal jam Pulang, (ex 16:00:00)</p>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="title">Persentase Kinerja</label>
							<div class="input-prepend input-append">
								<input type="text" name="kinerja" id="kinerja" class="span4" value="<?php echo set_value('kinerja', isset($settings['site.kinerja']) ? $settings['site.kinerja'] : '') ?>" />
								<span class="add-on">%</span>
								
							</div>
							<p class="help-inline">Persentase Perhitungan Tukin dari Kinerja (SKP)</p>
						</div>
						<div class="control-group">
							<label class="control-label" for="title">Persentase Kehadiran</label>
							<div class="input-prepend input-append">
								<input type="text" name="kehadiran" id="kehadiran" class="span4" value="<?php echo set_value('kehadiran', isset($settings['site.kehadiran']) ? $settings['site.kehadiran'] : '') ?>" />
								<span class="add-on">%</span>
								
							</div>
							<p class="help-inline">Persentase Perhitungan Tukin dari kehadiran</p>
						</div>
					</fieldset>
					<fieldset>
						<legend>Setting Service Simpeg</legend>
						<div class="control-group">
							<label class="control-label" for="list_limit">User Simpeg</label>
							<div class="controls">
								<input type="text" name="usersimpeg" id="usersimpeg" value="<?php echo set_value('usersimpeg', isset($settings['site.usersimpeg']) ? $settings['site.usersimpeg'] : '')  ?>" class="span6" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="list_limit">Password Simpeg</label>
							<div class="controls">
								<input type="password" name="passsimpeg" id="passsimpeg" value="<?php echo set_value('passsimpeg', isset($settings['site.passsimpeg']) ? $settings['site.passsimpeg'] : '')  ?>" class="span6" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="list_limit">Token</label>
							<div class="controls">
								<input type="text" name="tokensimpeg" id="tokensimpeg" value="<?php echo set_value('tokensimpeg', isset($settings['site.tokensimpeg']) ? $settings['site.tokensimpeg'] : '')  ?>" class="span6" />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend>Setting SAS</legend>
						<div class="control-group">
							<label class="control-label" for="list_limit">Host</label>
							<div class="controls">
								<input type="text" name="sashost" id="sashost" value="<?php echo set_value('sashost', isset($settings['site.sashost']) ? $settings['site.sashost'] : '')  ?>" class="span6" />
								<p class="help-inline">Host/IP komputer SAS</p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="list_limit">Username</label>
							<div class="controls">
								<input type="text" name="sasusername" id="sasusername" value="<?php echo set_value('sasusername', isset($settings['site.sasusername']) ? $settings['site.sasusername'] : '')  ?>" class="span6" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="list_limit">Password</label>
							<div class="controls">
								<input type="text" name="saspassword" id="saspassword" value="<?php echo set_value('saspassword', isset($settings['site.saspassword']) ? $settings['site.saspassword'] : '')  ?>" class="span6" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="list_limit">Nama Database</label>
							<div class="controls">
								<input type="text" name="sasdatabase" id="sasdatabase" value="<?php echo set_value('sasdatabase', isset($settings['site.sasdatabase']) ? $settings['site.sasdatabase'] : '')  ?>" class="span6" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="list_limit">Port</label>
							<div class="controls">
								<input type="text" name="sasport" id="sasport" value="<?php echo set_value('sasport', isset($settings['site.sasport']) ? $settings['site.sasport'] : '')  ?>" class="span6" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="title">Kode Satker</label>
							<div class="controls">
								<input type="text" name="kodesatker" id="kodesatker"  class="span2" value="<?php echo set_value('site.kodesatker', isset($settings['site.kodesatker']) ? $settings['site.kodesatker'] : '') ?>" />
								<p class="help-inline">Isi dengan kode satker yang ada di aplikasi SAS (ex : 450052)</p>
							</div>
						</div>
					</fieldset>
				</div>
				<!-- Start of Security Settings Tab Pane -->
				<div class="tab-pane" id="security">
					<fieldset>
						<legend><?php echo lang('bf_security') ?></legend>

						<div class="control-group">
							<div class="controls">
								<label for="allow_register">
									<input type="checkbox" name="allow_register" id="allow_register" value="1" <?php echo $settings['auth.allow_register'] == 1 ? 'checked="checked"' : set_checkbox('auth.allow_register', 1); ?> />
									<span><?php echo lang('bf_allow_register') ?></span>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="user_activation_method"><?php echo lang('bf_activate_method') ?></label>
							<div class="controls">
								<select name="user_activation_method" id="user_activation_method">
									<option value="0" <?php echo $settings['auth.user_activation_method'] == 0 ? 'selected="selected"' : ''; ?>><?php echo lang('bf_activate_none') ?></option>
									<option value="1" <?php echo $settings['auth.user_activation_method'] == 1 ? 'selected="selected"' : ''; ?>><?php echo lang('bf_activate_email') ?></option>
									<option value="2" <?php echo $settings['auth.user_activation_method'] == 2 ? 'selected="selected"' : ''; ?>><?php echo lang('bf_activate_admin') ?></option>
								</select>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="login_type"><?php echo lang('bf_login_type') ?></label>
							<div class="controls">
								<select name="login_type" id="login_type">
									<option value="email" <?php echo $settings['auth.login_type'] == 'email' ? 'selected="selected"' : ''; ?>><?php echo lang('bf_login_type_email') ?></option>
									<option value="username" <?php echo $settings['auth.login_type'] == 'username' ? 'selected="selected"' : ''; ?>><?php echo lang('bf_login_type_username') ?></option>
									<option value="both" <?php echo $settings['auth.login_type'] == 'both' ? 'selected="selected"' : ''; ?>><?php echo lang('bf_login_type_both') ?></option>
								</select>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" id="use_usernames_label"><?php echo lang('bf_use_usernames') ?></label>
							<div class="controls" aria-labelledby="use_usernames_label" role="group">
								<label class="radio" for="use_username">
									<input type="radio" id="use_username" name="use_usernames" value="1" <?php echo $settings['auth.use_usernames'] == 1 ? 'checked="checked"' : set_radio('auth.use_usernames', 1); ?> />
									<span><?php echo lang('bf_username') ?></span>
								</label>
								<label class="radio" for="use_email">
									<input type="radio" id="use_email" name="use_usernames" value="0" <?php echo $settings['auth.use_usernames'] == 0 ? 'checked="checked"' : set_radio('auth.use_usernames', 0); ?> />
									<span><?php echo lang('bf_email') ?></span>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('bf_display_name'); ?></label>
							<div class="controls">
								<label class="checkbox" for="allow_name_change">
									<input type="checkbox" name="allow_name_change" id="allow_name_change" <?php echo isset($settings['auth.allow_name_change']) && $settings['auth.allow_name_change'] == 1 ? 'checked="checked"' : set_checkbox('auth.allow_remember', 1); ?> >
									<?php echo lang('set_allow_name_change_note'); ?>
								</label>

								<div id="name-change-settings" style="<?php if (!$settings['auth.allow_name_change']) echo 'display: none'; ?>">
									<input type="text" name="name_change_frequency" style="width: 2em;" value="<?php echo $settings['auth.name_change_frequency'] ?>">
									<?php echo lang('set_name_change_frequency') ?>

									<input type="text" name="name_change_limit" style="width: 2em;" value="<?php echo $settings['auth.name_change_limit'] ?>">
									<?php echo lang('set_days') ?>
								</div>
							</div>
						</div>

						<div class="control-group">
							<div class="controls">
								<label class="checkbox" for="allow_remember">
									<input type="checkbox" name="allow_remember" id="allow_remember" value="1" <?php echo $settings['auth.allow_remember'] == 1 ? 'checked="checked"' : set_checkbox('auth.allow_remember', 1); ?> />
									<span><?php echo lang('bf_allow_remember') ?></span>
								</label>
							</div>
						</div>

						<div class="control-group" id="remember-length" style="<?php if (!$settings['auth.allow_remember']) echo 'display: none'; ?>">
							<label class="control-label" for="remember_length"><?php echo lang('bf_remember_time') ?></label>
							<div class="controls">
								<select name="remember_length" id="remember_length">
									<option value="604800"  <?php echo $settings['auth.remember_length'] == '604800' ?  'selected="selected"' : '' ?>>1 <?php echo lang('bf_week') ?></option>
									<option value="1209600" <?php echo $settings['auth.remember_length'] == '1209600' ? 'selected="selected"' : '' ?>>2 <?php echo lang('bf_weeks') ?></option>
									<option value="1814400" <?php echo $settings['auth.remember_length']== '1814400' ? 'selected="selected"' : '' ?>>3 <?php echo lang('bf_weeks') ?></option>
									<option value="2592000" <?php echo $settings['auth.remember_length'] == '2592000' ? 'selected="selected"' : '' ?>>30 <?php echo lang('bf_days') ?></option>
								</select>
							</div>
						</div>

						<div class="control-group" id="password-strength">
							<label class="control-label" for="password_min_length"><?php echo lang('bf_password_strength') ?></label>
							<div class="controls">
								<input type="text" name="password_min_length" id="password_min_length" value="<?php echo set_value('password_min_length', isset($settings['auth.password_min_length']) ? $settings['auth.password_min_length'] : '') ?>" class="span1" />
								<p class="help-inline"><?php echo lang('bf_password_length_help') ?></p>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('set_option_password'); ?></label>
							<div class="controls">
								<label class="checkbox" for="password_force_numbers">
									<input type="checkbox" name="password_force_numbers" id="password_force_numbers" value="1" <?php echo set_checkbox('password_force_numbers', 1, isset($settings['auth.password_force_numbers']) && $settings['auth.password_force_numbers'] == 1 ? TRUE : FALSE); ?> />
									<?php echo lang('bf_password_force_numbers') ?>
								</label>
								<label class="checkbox" for="password_force_symbols">
									<input type="checkbox" name="password_force_symbols" id="password_force_symbols" value="1" <?php echo set_checkbox('password_force_symbols', 1, isset($settings['auth.password_force_symbols']) && $settings['auth.password_force_symbols'] == 1 ? TRUE : FALSE); ?> />
									<?php echo lang('bf_password_force_symbols') ?>
								</label>
								<label class="checkbox" for="password_force_mixed_case">
									<input type="checkbox" name="password_force_mixed_case" id="password_force_mixed_case" value="1" <?php echo set_checkbox('password_force_mixed_case', 1, isset($settings['auth.password_force_mixed_case']) && $settings['auth.password_force_mixed_case'] == 1 ? TRUE : FALSE); ?> />
									<?php echo lang('bf_password_force_mixed_case') ?>
								</label>
								<label class="checkbox" for="password_show_labels">
									<input type="checkbox" name="password_show_labels" id="password_show_labels" value="1" <?php echo set_checkbox('password_show_labels', 1, isset($settings['auth.password_show_labels']) && $settings['auth.password_show_labels'] == 1 ? TRUE : FALSE); ?> />
									<?php echo lang('bf_password_show_labels') ?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label for="password_iterations" class="control-label"><?php echo lang('set_password_iterations') ?></label>
							<div class="controls">
								<select name="password_iterations" style="width: auto">
									<option <?php echo set_select('password_iterations', 2, $settings['password_iterations'] == 2) ?>>2</option>
									<option <?php echo set_select('password_iterations', 4, $settings['password_iterations'] == 4) ?>>4</option>
									<option <?php echo set_select('password_iterations', 8, $settings['password_iterations'] == 8) ?>>8</option>
									<option <?php echo set_select('password_iterations', 16, $settings['password_iterations'] == 16) ?>>16</option>
									<option <?php echo set_select('password_iterations', 31, $settings['password_iterations'] == 31) ?>>31</option>
								</select>
								<span class="help-inline"><?php echo lang('bf_password_iterations_note'); ?></span>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="force_pass_reset"><?php echo lang('set_force_reset') ?></label>
							<div class="controls">
								<a href="<?php echo site_url(SITE_AREA .'/settings/users/force_password_reset_all'); ?>" class="btn btn-danger" onclick="return confirm('<?php echo lang('set_password_reset_confirm') ?>');">
									<?php echo lang('set_reset'); ?>
								</a>
								<span class="help-inline"><?php echo lang('set_reset_note'); ?></span>
							</div>
						</div>
					</fieldset>
				</div>
			<?php if (has_permission('Site.Developer.View')) : ?>
				<!-- Start of Developer Settings Tab Pane -->
				<div class="tab-pane" id="developer">
					<fieldset>
						<legend><?php echo lang('set_option_developer'); ?></legend>

						<div class="control-group">
							<div class="controls">
								<label class="checkbox" for="show_profiler">
									<input type="checkbox" name="show_profiler" id="show_profiler" value="1" <?php echo  $settings['site.show_profiler'] == 1 ? 'checked="checked"' : set_checkbox('auth.use_extended_profile', 1); ?> />
									<span><?php echo lang('bf_show_profiler') ?></span>
								</label>
								<label class="checkbox" for="show_front_profiler">
									<input type="checkbox" name="show_front_profiler" id="show_front_profiler" value="1" <?php echo  $settings['site.show_front_profiler'] == 1 ? 'checked="checked"' : set_checkbox('site.show_front_profiler', 1); ?> />
									<span><?php echo lang('bf_show_front_profiler') ?></span>
								</label>
								<label class="checkbox" for="do_check">
									<input type="checkbox" name="do_check" id="do_check" value="1" <?php echo $settings['updates.do_check'] == 1 ? 'checked="checked"' : set_checkbox('updates.do_check', 1); ?> />
									<span><?php echo lang('bf_do_check') ?></span>
									<p class="help-block"><?php echo lang('bf_do_check_edge') ?></p>
								</label>
								<label class="checkbox" for="bleeding_edge">
									<input type="checkbox" name="bleeding_edge" id="bleeding_edge" value="1" <?php echo $settings['updates.bleeding_edge'] == 1 ? 'checked="checked"' : set_checkbox('updates.bleeding_edge', 1); ?> />
									<span><?php echo lang('bf_update_show_edge') ?></span>
									<p class="help-block"><?php echo lang('bf_update_info_edge') ?></p>
								</label>
							</div>
						</div>

					</fieldset>
				</div>
				<!-- End of Developer Tab Options Pane -->
			<?php endif;
				if ($show_extended_settings) :
			?>
				<!-- Start of Extended Settings Tab Pane -->
				<div class='tab-pane' id='extended'>
					<fieldset>
						<legend><?php echo lang('set_option_extended'); ?></legend>
				<?php
					foreach ($extended_settings as $field)
					{
						if ( empty($field['permission'])
							|| $field['permission'] === FALSE
							|| ( ! empty($field['permission']) && has_permission($field['permission']))
							)
						{
							$form_error_class = form_error($field['name']) ? ' error' : '';
							$field_control = '';

							if ($field['form_detail']['type'] == 'dropdown')
							{
								echo form_dropdown($field['form_detail']['settings'], $field['form_detail']['options'], set_value($field['name'], isset($settings['ext.' . $field['name']]) ? $settings['ext.' . $field['name']] : ''), $field['label']);
							}
							elseif ($field['form_detail']['type'] == 'checkbox')
							{
								$field_control = form_checkbox($field['form_detail']['settings'], $field['form_detail']['value'], isset($settings['ext.' . $field['name']]) && $field['form_detail']['value'] == $settings['ext.' . $field['name']] ? TRUE : FALSE);
							}
							elseif ($field['form_detail']['type'] == 'state_select')
							{
								if ( ! is_callable('state_select'))
								{
									$this->load->config('address');
									$this->load->helper('address');
								}
								$field_control = state_select(isset($settings['ext.' . $field['name']]) ? $settings['ext.' . $field['name']] : 'CA', 'CA', 'US', $field['name'], 'span6 chzn-select');
							}
							elseif ($field['form_detail']['type'] == 'country_select')
							{
								if ( ! is_callable('country_select'))
								{
									$this->load->config('address');
									$this->load->helper('address');
								}
								$field_control = country_select(set_value($field['name'], isset($settings['ext.' . $field['name']]) ? $settings['ext.' . $field['name']] : 'US'), 'US', $field['name'], 'span6 chzn-select');
							}
							else
							{
								$form_method = 'form_' . $field['form_detail']['type'];
								if (is_callable($form_method))
								{
									echo $form_method($field['form_detail']['settings'], set_value($field['name'], isset($settings['ext.' . $field['name']]) ? $settings['ext.' . $field['name']] : ''), $field['label']);
								}
							}

							if ( ! empty($field_control)) :
						?>
								<div class="control-group<?php echo $form_error_class; ?>">
									<label class="control-label" for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
									<div class="controls">
										<?php echo $field_control; ?>
									</div>
								</div>
						<?php
							endif;
						}
					}
				?>
					</fieldset>
				</div>
			<?php endif; ?>
			</div>
		</div>

		<div class="form-actions">
			<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('bf_action_save') . ' ' . lang('bf_context_settings'); ?>" />
		</div>

	<?php echo form_close(); ?>
</div><!-- /admin-box -->
<script type="text/javascript">	  
$('.timeformat').timepicker({ 'timeFormat': 'H:i:s' });
</script>
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