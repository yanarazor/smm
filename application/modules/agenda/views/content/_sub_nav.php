<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/agenda') ?>" id="list"><?php echo lang('agenda_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Agenda.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/agenda/create') ?>" id="create_new"><?php echo lang('agenda_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>