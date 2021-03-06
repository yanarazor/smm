<?php if (isset($role_counts) && is_array($role_counts) && count($role_counts)) : ?>
<div class="admin-box">

	<p class="intro"><?php e(lang('role_intro')) ?></p>

	<table class="table table-striped">
		<thead>
			<tr>
				<th style="width: 20px">No</th>
				<th style="width: 10em"><?php echo lang('role_account_type'); ?></th>
				<th class="text-center" style="width: 5em"># <?php echo lang('bf_users'); ?></th>
				<th><?php echo lang('role_description') ?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$no = 1;
		foreach ($roles as $role) : ?>
			<tr>
				<td><?php echo $no; ?>.</td>
				<td><?php echo anchor(SITE_AREA .'/settings/roles/edit/'. $role->role_id, $role->role_name) ?></td>
				<td class="text-center"><?php
						$count = 0;
						foreach ($role_counts as $r)
						{
							if ($role->role_name == $r->role_name)
							{
								$count = $r->count;
							}
						}

						echo $count;
					?>
				</td>
				<td><?php e($role->description) ?></td>
			</tr>
		<?php 
		$no++;
		endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>
