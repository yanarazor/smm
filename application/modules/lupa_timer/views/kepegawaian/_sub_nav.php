<!--
<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/lupa_timer') ?>" id="list"><?php echo lang('lupa_timer_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Lupa_Timer.Kepegawaian.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/kepegawaian/lupa_timer/create') ?>" id="create_new"><?php echo lang('lupa_timer_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>
-->