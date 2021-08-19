<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
</button>
<ul class="navbar-nav mr-auto">
	<li class="nav-item dropdown megamenu">
		<a id="megamneu" href="" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><?= lang('produse') ?></a>
		<div aria-labelledby="megamneu" class="dropdown-menu megamenu-list categorii">
			
			<? foreach(categorii_top() as $c): ?>
			<span>
				<a href="<?= categorie_url($c) ?>">
					<img src="<?= base_url() ?>assets/images/meniu/<?= $c['imagine'] ?>" />
				</a>    
			</span>
			<? endforeach ?>
		</div>
	</li>
	<li class="nav-item"><a class="nav-link" href="<?= site_url('despre_noi') ?>"><?= lang('despre_noi') ?></a></li>
	<li class="nav-item dropdown megamenu">
		<a class="nav-link" href="javascript:;" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= lang('catalog') ?></a>
		<ul class="dropdown-menu megamenu-list" aria-labelledby="dropdown02">
			<? $cataloage = $this->magazin_db->cataloage(array(), array('id' => 'desc')) ?>
			<? foreach($cataloage as $c): ?>
			<li>
				<a href="<?= site_url('catalog/'.$c['id']) ?>">
					<?= $c['denumire'.$this->session->userdata('fieldLang')]!=''?$c['denumire'.$this->session->userdata('fieldLang')]:$c['denumire'] ?>
				</a>
			</li>
			<? endforeach ?>
		</ul>
	</li>
	<li class="nav-item"><a class="nav-link" href="<?= site_url('contact') ?>"><?= lang('contact') ?></a></li>
</ul>