<? $folder = $this->session->userdata('folderView')==''?'':$this->session->userdata('folderView').'/' ?>
<footer class="mt-5">
	<div class="footer-beneficii">
		<div class="container">
			<div class="row">
				<div class="col-md-2 col-4 text-center">
					<a href="<?= site_url('livrare_24h.html') ?>">
						<img class="img-fluid" style="max-height: 75px"  src="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>livrare.png" data-image-second="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>livrare_o.png" />
					</a>
				</div>
				<div class="col-md-2 col-4 text-center">
					<a href="<?= site_url('suport_telefonic.html') ?>">
						<img class="img-fluid" style="max-height: 75px" src="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>suport.png" data-image-second="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>suport_o.png" />
					</a>
				</div>
				<div class="col-md-2 col-4 text-center">
					<a href="<?= site_url('garantii.html') ?>">
						<img class="img-fluid" style="max-height: 75px" src="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>garantii.png" data-image-second="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>garantii_o.png" />
					</a>
				</div>
				<div class="col-md-2 col-4 text-center">
					<a href="<?= site_url('cumperi_mai_mult_platesti_mai_putin.html') ?>">
						<img class="img-fluid" style="max-height: 75px" src="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>cumperi_mai_mult.png" data-image-second="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>cumperi_mai_mult_o.png" />
					</a>
				</div>
				<div class="col-md-2 col-4 text-center">
					<a href="<?= site_url('certificate.html') ?>">
						<img class="img-fluid" style="max-height: 75px" src="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>certificate.png" data-image-second="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>certificate_o.png" />
					</a>
				</div>
				<div class="col-md-2 col-4 text-center">
					<a href="<?= site_url('termen_de_plata.html') ?>">
						<img class="img-fluid" style="max-height: 75px" src="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>termen_de_plata.png" data-image-second="<?= base_url() ?>assets/images/beneficii/<?= $folder ?>termen_de_plata_o.png" />
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="container mt-2 mb-2">
		<div class="row">
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-6">
						<ul>
							<li><i class="fa fa-map-marker-alt"></i> Şos. Borsului nr 72, loc Sântion, jud. Bihor</li>
							<li><i class="fa fa-envelope"></i> comenzi@globiz.ro</li>
						</ul>
					</div>
					<div class="col-md-6">
						<ul>
							<li><i class="fa fa-mobile-alt"></i> +40 359 306 158 ; +40 728 777 776</li>
							<!--<li><i class="fab fa-skype"></i> budai.janos.mnc</li>-->
						</ul>
					</div>
					<div class="col-md-12 text-center footer-program">
						<?= lang('program_de_lucru') ?>: <b><?= lang('L-V') ?>: 8:45 - 16:45</b>
					</div>
				</div>
			</div>
			<div class="col-md-5 footer-links">
				<div class="row">
					<div class="col-6">
						<ul class="list">
							<li><a href="<?= site_url() ?>" /><?= lang('pro_duse') ?></a></li>
							<li><a href="<?= site_url('despre_noi') ?>"><?= lang('despre_noi') ?></a></li>
							<li><a href="<?= site_url('contact') ?>"><?= lang('con_tact') ?></a></li>
							<li><a href="<?= site_url('utilizator/login') ?>"><?= lang('inregistrare') ?></a></li>
						</ul>
					</div>
					<div class="col-6">
						<ul class="list">
							<li><a href="<?= site_url() ?>" /><?= lang('intrebari_frecvente') ?></a></li>
							<li><a href="http://www.anpc.gov.ro/" target="_blank"><?= lang('anpc') ?></a></li>
							<li><a href="<?= site_url('termeni_si_conditii') ?>"><?= lang('termeni_si_conditii') ?></a></li>
							<li><a href="<?= site_url('gdpr') ?>"><?= lang('gdpr') ?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="container">
		<p><div class="copyright"><?= lang('copyright') ?></div></p>
	</div>
</footer>