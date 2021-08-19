<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('garantii') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-3 offset-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-8">
				<div class="row">
					<div class="col-md-12">
						<?= form_open_multipart('utilizator/adauga_garantie', '  class="form-horizontal"') ?>
							<div class="form-body">
								<?= isset($error)?$error:''; ?>
								<div>
									<label><?= lang('codprodus') ?></label>
									<input type="text" class="form-control" name="cod_produs" id="cod_produs" value="<?= set_value('cod_produs') ?>">
									<input type="hidden" name="produs_id" id="produs_id" value="<?= set_value('produs_id') ?>">
								</div>
								<div>
									<label><?= lang('bon_factura') ?></label>
									<input type="file" id="exampleBonFiscal" name="bon_fiscal" accept="image/*">
								</div>
								<div>
									<label><?= lang('certificat_de_garantie') ?></label>
									<input type="file" id="exampleCertificat" name="certificat" accept="image/*">
								</div>
								<div>
									<label><?= lang('observatie') ?></label>
									<textarea rows="3" class="form-control" name="observatie"><?= set_value('observatie') ?></textarea>
								</div>
							</div>
							<div class="form-actions pt-2">
								<div>
									<button type="submit" class="btn btn-globiz btn-shadow"><?= lang('adauga') ?></button>
								</div>
							</div>
						<?= form_close() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>