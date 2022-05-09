<div>
	<div class="bg-dark">
		<div class="container">
			<div class="d-md-flex flex-column flex-md-row align-items-center">
				<div class="my-0 mr-md-auto font-weight-normal text-center">
					<a href="mailto: comenzi@globiz.ro"><i class="fa fa-envelope"></i> comenzi@globiz.ro</a>&nbsp;&nbsp;
					<a href="tel: +40359306158" class="ml-5 d-inline-block"><i class="fa fa-mobile-alt" aria-hidden="true"></i> +40 359 306 158</a>
				</div>
				<div class="my-2 my-md-0 text-center">
					<ul>
						<? if ( ! $this->session->userdata('loggedFrontend') ): ?>
						<li class="mr-3">
							<a href="<?= site_url('utilizator/login') ?>"><i class="fa fa-user"></i> <span><?= lang('autentificare') ?></span></a>
						</li>
						<? else: ?>
						<li class="mr-3">
							<a href="<?= site_url('utilizator') ?>"><i class="fa fa-user"></i> <span><?= $this->session->userdata('utilizator') ?></span></span></a>
						</li>
						<li class="mr-3">
							<a href="<?= site_url('utilizator/deconectare') ?>"><i class="fas fa-sign-out-alt"></i> <span><?= lang('Logout') ?></span></span></a>
						</li>
						<? endif ?>
						<li class="dropdown flags mr-3">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
								<? switch ($this->input->cookie('language_frontend')) {
									case 'en':
										$src = base_url().'assets/images/gb.png';
										$text = 'EN';
										break;
									
									default:
										$src = base_url().'assets/images/ro.png';
										$text = 'RO';
										break;
								} ?>
								<img src="<?= $src ?>" alt=""/> <?= $text ?> <i class="la la-angle-double-down"></i>
							</a>
							<ul role="menu" class="dropdown-menu">
								<? switch ($this->input->cookie('language_frontend')) {
									case 'en':  ?>
										<li><a href="javascript:void(0)" onclick="schimba_limba('ro')"><img src="<?= base_url() ?>assets/images/ro.png" alt=""/> RO</a></li>
								<?		break;
									default: ?>
										<li><a href="javascript:void(0)" onclick="schimba_limba('en')"><img src="<?= base_url() ?>assets/images/gb.png" alt=""/> EN</a></li>
								<?		break;
								} ?>
							</ul>
						</li>
						<? if ( $this->session->userdata('loggedFrontend') ): ?>
							<li class="position-relative cos-top">
								<a href="javascript:;" class="ml-3 dropdown">
									<img src="<?= base_url() ?>assets/images/cart.png" class="cart-logo" title="cart"/>
									<span id="cos_top_sumar"><? $this->load->view('cos/cos_top_sumar') ?></span>
									<i class="la la-angle-double-down"></i>
								</a>
								<div class="shopping-cart-top" id="cos_top_list">
									<? $this->load->view('cos/cos_top_list') ?>
								</div>
							</li>
						<? endif ?>
					</ul>
				<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<? /*
	<div class="bg-orange">
		<div class="container">
			<div class="text-center">
				Comenzile plasate in perioada 21.12.2019-05.01.2020 se vor procesa dupa 06.01.2020
			</div>
		</div>
	</div>
	*/ ?>
	<nav class="navbar navbar-expand-lg">
		<div class="container d-flex flex-column flex-md-row menu">
			<? $folder = $this->session->userdata('folderView')==''?'':$this->session->userdata('folderView').'/' ?>
			<div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fas fa-bars"></i>
				</button>
				<a href="<?= site_url() ?>" class="logo"><img src="<?= site_url('assets/images/logo.png') ?>" alt="Globiz logo" title="Globiz"/></a>
			</div>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<? if(isset($is_home) and ($is_home)): ?>
				<ul class="navbar-nav navbar-nav mr-auto">
					<li class="nav-item dropdown megamenu">
						<a id="megamneu" href="" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><?= lang('produse') ?></a>
						<div aria-labelledby="megamneu" class="dropdown-menu megamenu-list categorii">
							<? foreach(categorii_top() as $c): ?>
								<?
								$_arr = explode(".", $c['imagine']);
								$ext = ".".end($_arr);
								$img_o = str_replace($ext, "", $c['imagine'])."_o".$ext;
								?>
								<a href="<?= categorie_url($c) ?>">
									<img src="<?= base_url() ?>assets/images/meniu/<?= $folder ?><?= $c['imagine'] ?>"  data-image-second="<?= base_url() ?>assets/images/meniu/<?= $folder ?><?= $img_o ?>"/>
								</a>
							<? endforeach ?>
						</div>
					</li>
					<li class="nav-item"><a class="nav-link" href="<?= site_url('despre_noi') ?>"><?= lang('despre_noi') ?></a></li>
					<li class="nav-item dropdown megamenu">
						<a class="nav-link" href="javascript:;" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= lang('catalog') ?></a>
						<ul class="dropdown-menu megamenu-list cataloage" aria-labelledby="dropdown02">
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
				<? else: ?>
					<div class="mr-auto nav-page">
						<? foreach(categorii_top_new() as $c): ?>
							<?
							$_arr = explode(".", $c['imagine']);
							$ext = ".".end($_arr);
							$img_o = str_replace($ext, "", $c['imagine'])."_o".$ext;
							if(isset($id_meniu) and ($id_meniu==$c['id'])){
								$img = $img_o;
							} else {
								$img = $c['imagine'];
							}
							?>
							<span class="top_meniu_categ">
								<a href="<?= categorie_url($c) ?>" class="d-inline-block ml-3">
									<img src="<?= base_url() ?>assets/images/meniu_pagini/<?= $folder ?><?= $img ?>"  data-image-second="<?= base_url() ?>assets/images/meniu_pagini/<?= $folder ?><?= $img_o ?>"/>
								</a>
								<? /*if(is_array($c['subcategorii']) and count($c['subcategorii'])): ?>
									<div class="subcategorii_top ml-3">
										<? foreach($c['subcategorii'] as $cat): ?>
											<div class="subcat">
												<div>
													<a href="<?= categorie_url($cat) ?>">
														<?= $cat['nume'.$this->session->userdata('fieldLang')]!=''?$cat['nume'.$this->session->userdata('fieldLang')]:$cat['nume'] ?>
													</a>
												</div>
												<? if(is_array($cat['subcategorii']) and count($cat['subcategorii'])): ?>
													<? foreach($cat['subcategorii'] as $subcat): ?>
														<div>
															<a href="<?= categorie_url($subcat) ?>">
																<?= $subcat['nume'.$this->session->userdata('fieldLang')]!=''?$subcat['nume'.$this->session->userdata('fieldLang')]:$subcat['nume'] ?>
															</a>
														</div>
													<? endforeach ?>
												<? endif ?>
											</div>
										<? endforeach ?>
									</div>
								<? endif */ ?>

							</span>
						<? endforeach ?>
					</div>
				<? endif ?>
				<div class="mt-2 mt-md-0 <? if(!(isset($is_home) and ($is_home))): ?>nav-page<? endif ?>">
					<? if(!(isset($is_home) and ($is_home))): ?>
					<div class="float-left mr-2">
						<a href="<?= site_url('produse_promotie') ?>" class="d-inline-block mr-2">
							<? $img = 'promo.png'; ?>
							<? if ((isset($current_page) and ($current_page == 'produse_oferta')) and (isset($tip) and ($tip == 'promotii'))): ?>
							<? $img = 'promo_o.png'; ?>
							<? endif ?>
							<img src="<?= base_url() ?>assets/images/meniu_pagini/<?= $folder ?><?= $img ?>"  data-image-second="<?= base_url() ?>assets/images/meniu_pagini/<?= $folder ?>promo_o.png"/>
						</a>
						<a href="<?= site_url('produse_noi') ?>" class="d-inline-block mr-2">
							<? $img = 'noutati.png'; ?>
							<? if ((isset($current_page) and ($current_page == 'produse_oferta')) and (isset($tip) and ($tip == 'nou'))): ?>
							<? $img = 'noutati_o.png'; ?>
							<? endif ?>
							<img src="<?= base_url() ?>assets/images/meniu_pagini/<?= $folder ?><?= $img ?>"  data-image-second="<?= base_url() ?>assets/images/meniu_pagini/<?= $folder ?>noutati_o.png"/>
						</a>
						<a href="<?= site_url('produse_lichidari') ?>" class="d-inline-block mr-2">
							<? $img = 'sale.png'; ?>
							<? if ((isset($current_page) and ($current_page == 'produse_oferta')) and (isset($tip) and ($tip == 'lichidari'))): ?>
							<? $img = 'sale_o.png'; ?>
							<? endif ?>
							<img src="<?= base_url() ?>assets/images/meniu_pagini/<?= $folder ?><?= $img ?>"  data-image-second="<?= base_url() ?>assets/images/meniu_pagini/<?= $folder ?>sale_o.png"/>
						</a>
					</div>
					<? endif ?>
					<form id="search" method="get" action="<?= base_url() ?>cautare" class="form-inline d-none d-lg-inline-block <? if(!(isset($is_home) and ($is_home))): ?>mt-2<? endif ?>">
						<input class="form-control mr-sm-2" type="text" placeholder="<?= lang('cautare')?>" name="s" aria-label="Search">
						<button class="btn my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
					</form>
				</div>
			</div>
		</div>
	</nav>
</div>
