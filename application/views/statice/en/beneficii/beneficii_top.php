
<? if ($this->session->userdata('fieldLang') == '') { ?>
	<div class="col-xs-2">
		<a href="<?= site_url('suport_telefonic.html') ?>">
			<? if($uri=='suport_telefonic'): ?>
				<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_suport_en.png" />
			<? else: ?>
				<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/suport_en.png" />
			<? endif ?>
		</a>
	</div>
<? } else { ?>
<div class="col-xs-1">
	&nbsp;
</div>
<? } ?>
<div class="col-xs-2">
	<a href="<?= site_url('garantii.html') ?>">
		<? if($uri=='garantii'): ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_garantii_en.png" />
		<? else: ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/garantii_en.png" />
		<? endif ?>
	</a>
</div>
<div class="col-xs-2">
	<a href="<?= site_url('cumperi_mai_mult_platesti_mai_putin.html') ?>">
		<? if($uri=='cumperi_mai_mult_platesti_mai_putin'): ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_cumperi_mai_mult_en.png" />
		<? else: ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/cumperi_mai_mult_en.png" />
		<? endif ?>
	</a>
</div>
<div class="col-xs-2">
	<a href="<?= site_url('certificate.html') ?>">
		<? if($uri=='certificate'): ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_certificate_en.png" />
		<? else: ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/certificate_en.png" />
		<? endif ?>
	</a>
</div>
<div class="col-xs-2">
	<a href="<?= site_url('termen_de_plata.html') ?>">
		<? if($uri=='termen_de_plata'): ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_termen_de_plata_en.png" />
		<? else: ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/termen_de_plata_en.png" />
		<? endif ?>
	</a>
</div>