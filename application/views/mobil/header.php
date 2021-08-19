<?
$no_articole = count($this->cart->contents());
$item = $this->cart->find_by_id('transport');
if(count($item)){
	$no_articole -=1;
}
$item = $this->cart->find_by_id('discount');
if(count($item)){
	$no_articole -=1;
}
?>
<div class="header-mobil">
	<div class="content d-flex">
		<div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fas fa-bars"></i>
			</button>
			<a href="<?= site_url() ?>" class="logo"><img src="<?= site_url('assets/images/logo.png') ?>" alt="Globiz logo" title="Globiz"/></a>
		</div>
		<div class="mx-0 ml-auto">
			<div class="d-inline-block search-top">
				<a href="javascript:;" class="dropdown" id="search-mobile-btn">
					<img src="<?= base_url() ?>assets/images/search-top.png" title="cart"/>
				</a>
			</div>
			<? if ( $this->session->userdata('loggedFrontend') ): ?>
				<div class="d-inline-block cos-top">
					<a href="<?= site_url('cos') ?>" class="dropdown">
						<img src="<?= base_url() ?>assets/images/cart_o.png" class="cart-logo" title="cart"/>
						<span class="badge badge-globiz" id="no_articole"><?= $no_articole ?></span>
					</a>
				</div>
			<? endif ?>
			<div class="d-inline-block user">
				<? if ( ! $this->session->userdata('loggedFrontend') ): ?>
					<a href="<?= site_url('utilizator/login') ?>"><i class="fa fa-user"></i><span>SIGN IN</span></a>
				<? else: ?>
					<a href="<?= site_url('utilizator') ?>"><i class="fa fa-user"></i><span><?= $this->session->userdata('utilizator') ?></span></a>
				<? endif ?>
			</div>
		</div>
	</div>
	<div class="collapse navbar-collapse" id="navbarCollapse">
		<ul class="nav">
			<? foreach ($categorii_mobil_meniu as $key => $c) { ?>
				<li>
					<a href="<?= categorie_url($c) ?>" <? if(count($c['submeniu'])): ?>class="sf-with-ul"<? endif ?>><?= $c['nume'] ?></a>
					<? if(count($c['submeniu'])): ?>
						<span class="visible-xs visible-sm sf-arrow">
							<i class="fa fa-angle-right"></i>
						</span>
					<? endif ?>
					<? if(count($c['submeniu'])): ?>
					<ul>
						<? foreach ($c['submeniu'] as $sc): ?>
						<li>
							<a href="<?= categorie_url($sc) ?>"><?= $sc['nume'] ?></a>
						</li>
						<? endforeach ?>
					</ul>
					<? endif ?>
				</li>
			<? } ?>
			<li><a href="<?= site_url('produse_promotie') ?>"><?= lang('promotii') ?></a></li>
			<li><a href="<?= site_url('produse_noi') ?>"><?= lang('noutati') ?></a></li>
			<li><a href="<?= site_url('produse_lichidari') ?>"><?= lang('lichidari') ?></a></li>
			<li><a href="<?= site_url('contact') ?>"><?= lang('contact') ?></a></li>                                 
		</ul>
	</div>
	<? /*
	<div class="bg-orange">
		<div class="container">
			<div class="text-center font-weight-bold">
				Comenzile plasate in <span class="d-none d-sm-block">perioada </span>21.12.2019-05.01.2020 se vor procesa dupa 06.01.2020
			</div>
		</div>
	</div>
	*/ ?>
</div>
<div class="search-mobile">
	<div class="container">
		<form id="search" method="get" action="<?= base_url() ?>cautare" class="form-inline">
			<input class="form-control mr-sm-2" type="text" placeholder="<?= lang('cautare')?>" name="s" aria-label="Search">
			<button class="btn my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
		</form>
	</div>
</div>