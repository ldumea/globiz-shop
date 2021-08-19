<section class="page-section breadcrumbs">
    <div class="container">
        <div class="page-header">
            <h1><?= lang('plata_comanda') ?> <?= $comanda['id'] ?>: <?= number_format($comanda['total'], 2, ".", "") ?> lei</h1>
        </div>
    </div>
</section>

<!-- PAGE WITH SIDEBAR -->
<section class="page-section with-sidebar">
    <div class="container">
        <div class="row">
        	<?php $this->load->view('utilizator/sidebar') ?>            
            <!-- CONTENT -->
            <div class="col-md-9 content" id="content">
            	<div class="row">
            		<div class="col-md-12">
						<?= form_open('utilizator/plateste_comanda/'.$comanda['id']) ?>
						<?= isset($error)?$error:''; ?>
						<div class="form-item">
							<label for="denumire">
								<?= lang('nume_firma') ?>
							</label>
							<input type="text" value="<?= set_value('denumire', $comanda['tert']['denumire']) ?>" name="denumire" id="denumire" size="60" class="form-control" />
						</div>
						<div class="form-item">
							<label for="cod_fiscal">
								<?= lang('cod_fiscal') ?>
							</label>
							<input type="text" value="<?= set_value('cod_fiscal', $comanda['tert']['cod_fiscal']) ?>" name="cod_fiscal" id="cod_fiscal" size="60" class="form-control" />
						</div>
						<div class="form-item">
							<label for="reg_com">
								<?= lang('nr_reg_com') ?>
							</label>
							<input type="text" value="<?= set_value('reg_com', $comanda['tert']['reg_com']) ?>" name="reg_com" id="reg_com" size="60" class="form-control" />
						</div>
						<div class="form-item">
							<label for="adresa">
								<?= lang('adresa') ?><span title="Acest camp este obligatoriu." class="form-required">*</span>
							</label>
							<input type="text" value="<?= set_value('adresa', $comanda['tert']['adresa']) ?>" name="adresa" id="adresa" size="60" class="form-control" />
						</div>
						<div class="form-item">
							<label for="adresa">
								<?= lang('oras') ?><span title="Acest camp este obligatoriu." class="form-required">*</span>
							</label>
							<input type="text" value="<?= set_value('oras', $comanda['tert']['oras']) ?>" name="oras" id="oras" size="60" class="form-control" />
						</div>
						<div class="form-item">
							<label for="adresa">
								<?= lang('cod_postal') ?><span title="Acest camp este obligatoriu." class="form-required">*</span>
							</label>
							<input type="text" value="<?= set_value('cod_postal', $comanda['tert']['cod_postal']) ?>" name="cod_postal" id="cod_postal" size="60" class="form-control" />
						</div>
						<div class="form-item">
							<label for="judet">
								<?= lang('judet') ?><span title="Acest camp este obligatoriu." class="form-required">*</span>
							</label>
							<?= form_dropdown('judet', $judet, set_value('judet', $comanda['tert']['judet']), 'class="form-control"') ?>
						</div>

						<div class="form-item">
							<label><?= lang('nume') ?><span title="Acest camp este obligatoriu." class="form-required">*</span></label>
							<input type="text" class="form-control" name="nume" value="<?= set_value('nume') ?>">
						</div>
						<div class="form-item">
							<label><?= lang('prenume') ?><span title="Acest camp este obligatoriu." class="form-required">*</span></label>
							<input type="text" class="form-control" name="prenume" value="<?= set_value('prenume') ?>">
						</div>
						<div class="form-item">
							<label><?= lang('telefon') ?><span title="Acest camp este obligatoriu." class="form-required">*</span></label>
							<input type="text" class="form-control" name="telefon" value="<?= set_value('telefon',  $comanda['tert_utilizator']['telefon']) ?>">
						</div>
						<div class="form-item">
							<label><?= lang('email') ?><span title="Acest camp este obligatoriu." class="form-required">*</span></label>
							<input type="text" class="form-control" name="email" value="<?= set_value('email', $comanda['tert_utilizator']['email']) ?>">
						</div>
						<div class="outer required">
                        	<div class="form-group af-inner">
								<button class="form-button form-button-submit btn btn-theme btn-theme-dark">
									<?= lang('plateste') ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>