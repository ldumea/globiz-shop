<? if ($this->session->userdata('fieldLang') == '') { ?>
	<div class="col-xs-2">
		<a href="<?= site_url('plata_12_rate.html') ?>">
			<? if($uri=='plata_12_rate'): ?>
				<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_plata_rate<?= $this->session->userdata('fieldLang')?>.png" />
			<? else: ?>
				<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/plata_rate<?= $this->session->userdata('fieldLang')?>.png" />
			<? endif ?>
		</a>
	</div>
<? } else { ?>
<div class="col-xs-1">
	&nbsp;
</div>
<? } ?>
<div class="col-xs-2">
	<a href="<?= site_url('suport_telefonic.html') ?>">
		<? if($uri=='suport_telefonic'): ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_suport<?= $this->session->userdata('fieldLang')?>.png" />
		<? else: ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/suport<?= $this->session->userdata('fieldLang')?>.png" />
		<? endif ?>
	</a>
</div>
<div class="col-xs-2">
	<a href="<?= site_url('garantii.html') ?>">
		<? if($uri=='garantii'): ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_garantii<?= $this->session->userdata('fieldLang')?>.png" />
		<? else: ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/garantii<?= $this->session->userdata('fieldLang')?>.png" />
		<? endif ?>
	</a>
</div>
<div class="col-xs-2">
	<a href="<?= site_url('cumperi_mai_mult_platesti_mai_putin.html') ?>">
		<? if($uri=='cumperi_mai_mult_platesti_mai_putin'): ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_cumperi_mai_mult<?= $this->session->userdata('fieldLang')?>.png" />
		<? else: ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/cumperi_mai_mult<?= $this->session->userdata('fieldLang')?>.png" />
		<? endif ?>
	</a>
</div>
<div class="col-xs-2">
	<a href="<?= site_url('certificate.html') ?>">
		<? if($uri=='certificate'): ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_certificate<?= $this->session->userdata('fieldLang')?>.png" />
		<? else: ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/certificate<?= $this->session->userdata('fieldLang')?>.png" />
		<? endif ?>
	</a>
</div>
<div class="col-xs-2">
	<a href="<?= site_url('termen_de_plata.html') ?>">
		<? if($uri=='termen_de_plata'): ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/o_termen_de_plata<?= $this->session->userdata('fieldLang')?>.png" />
		<? else: ?>
			<img class="img-responsive" src="<?= base_url().THEMESFOLDER ?>images/beneficii/termen_de_plata<?= $this->session->userdata('fieldLang')?>.png" />
		<? endif ?>
	</a>
</div>