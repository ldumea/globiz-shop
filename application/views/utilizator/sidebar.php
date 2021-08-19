<div class="sidebar">
	<div class="sidebar-title">
		<?= lang('Numele meu') ?>:<br />
		<b><?= $this->session->userdata('nume') ?></b>
	</div>
	<ul>
		<li><a href="<?= site_url('utilizator') ?>" class="text-uppercase d-block"><?= lang('informatii') ?></a></li>
		<li><a href="<?= site_url('utilizator/utilizatori') ?>" class="text-uppercase d-block"><?= lang('utilizatori') ?></a></li>
		<li><a href="<?= site_url('utilizator/comenzi') ?>" class="text-uppercase d-block"><?= lang('comenzile_mele') ?></a></li>
		<li><a href="<?= site_url('utilizator/facturi') ?>" class="text-uppercase d-block"><?= lang('Facturile mele') ?></a></li>
		<li><a href="<?= site_url('utilizator/precomenzi') ?>" class="text-uppercase d-block"><?= lang('precomenzi') ?></a></li>
		<li><a href="<?= site_url('utilizator/garantii') ?>" class="text-uppercase d-block"><?= lang('garantii') ?></a></li>
		<li><a href="<?= site_url('utilizator/adrese_livrare') ?>" class="text-uppercase d-block"><?= lang('adrese_livrare') ?></a></li>
		<? if($this->session->userdata('feed_activ')==1): ?>
		<li><a href="<?= site_url('utilizator/feeduri') ?>" class="text-uppercase d-block"><?= lang('feeduri') ?></a></li>
		<? endif ?>
		<li><a href="<?= site_url('utilizator/deconectare') ?>" class="text-uppercase d-block"><?= lang('deconectare') ?></a></li>
	</ul>
</div>