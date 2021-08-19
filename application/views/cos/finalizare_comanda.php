<section class="finalizare-comanda">
	<div class="container">
		<h1 class="page-title"><div><span><?= lang('Detalii comandă') ?></span></div></h1>
		<form action="<?= site_url('cos/finalizare_comanda') ?>" method="post" enctype="multipart/form-data">
		<div class="cos_continut">
			<div class="row">
				<div class="offset-md-3 col-md-6">
					<div class="row">
						<? if($error!=''): ?>
						<div class="col-12">
							<?= $error ?>
						</div>
						<? endif ?>
						<div class="col-12 total text-center">
							<?= lang('total_comanda') ?>: <strong><?= number_format($cos['total'],2) ?> <?= $moneda ?></strong>
						</div>
						<div class="offset-2 col-8">
							<hr class="gray">
						</div>
						<div class="col-12">
							<div class="row rand">
								<div class="col-4 text-center info">
									<span><?= lang('denumire') ?>:</span>
								</div>
								<div class="col-8 val">
									<span><?= $utilizator['denumire'] ?></span>
								</div>
							</div>
							<div class="row rand">
								<div class="col-4 text-center info">
									<span><?= lang('cod_fiscal') ?>:</span>
								</div>
								<div class="col-8 val">
									<span><?= $utilizator['cod_fiscal'] ?></span>
								</div>
							</div>
							<div class="row rand">
								<div class="col-4 text-center info">
									<span><?= lang('nr_reg_com') ?>:</span>
								</div>
								<div class="col-8 val">
									<span><?= $utilizator['reg_com'] ?></span>
								</div>
							</div>
							<div class="row rand">
								<div class="col-3 text-center info">
									<span><?= lang('tara') ?>:</span>
								</div>
								<div class="col-3 val">
									<span><?= $tara[$utilizator['tara']] ?></span>
								</div>
								<div class="col-3 text-center info">
									<span><?= lang('judet') ?>:</span>
								</div>
								<div class="col-3 val">
									<span>
										<? if($utilizator['tara']=='RO'): ?>
											<?= $judete[$utilizator['judet']] ?>
										<? else: ?>
											<?= $utilizator['judet'] ?>
										<? endif ?>
									</span>
								</div>
							</div>
							<div class="row rand">
								<div class="col-4 text-center info">
									<span><?= lang('adresa') ?>:</span>
								</div>
								<div class="col-8 val">
									<span><?= $utilizator['adresa'] ?></span>
								</div>
							</div>
							<? if($this->session->userdata('dropshipping')==1): ?>
							<div class="row rand">
								<div class="col-4 text-center info">
									<span><?= lang('Dropshipping') ?>:</span>
								</div>
								<div class="col-8 val">
									
									<span style="color: #f00">
										<input type="checkbox" value="1" name="dropshipping" <? if(set_value('dropshipping', $this->session->userdata('dropshipping'))==1): ?>checked<? endif ?> onchange="schimba_dropshipping()" id="dropshipping" style="vertical-align: text-top;">
										Dezactiveaza daca comanda nu este de tip dropshipping!!!
									</span>
								</div>
							</div>
							<div class="<? if(!(set_value('dropshipping', $this->session->userdata('dropshipping'))==1)): ?>dn<? endif ?>" id="factura_awb_div">
								<div class="row rand">
									<div class="col-4 text-center info">
										<span><?= lang('Factura') ?>:</span>
									</div>
									<div class="col-8 val">
										<input type='file' name="fisier_factura" />
									</div>
								</div>
								<div class="row rand">
									<div class="col-4 text-center info">
										<span><?= lang('AWB') ?>:</span>
									</div>
									<div class="col-8 val">
										<input type='file' name="fisier_awb" />
									</div>
								</div>
							</div>
							<? endif ?>
							<div class="row rand <? if(set_value('dropshipping', $this->session->userdata('dropshipping'))==1): ?>dn<? endif ?>" id="adresa_livrare_div">
								<div class="col-12">
									<?= lang('adresa_livrare') ?>:
								</div>
								<div class="col-12">
									<?= form_dropdown('adresa_id', $adrese_livrare, set_value('adresa_id'), 'title="'.lang('selectati_adresa').'" class="form-control"') ?>
								</div>
							</div>
							<div class="row">
								<div class="col-4 text-center info">
									<span><?= lang('nota_factura') ?>:</span>
								</div>
								<div class="col-8 val">
									<textarea name="nota" style="height: 58px" class="form-control"><?= set_value('nota') ?></textarea>
								</div>
							</div>
							<div class="row">
								<div class="offset-2 col-8 mt-4">
									<a href="<?= site_url() ?>" class="btn btn-gray d-block mb-2"><?= lang('continua_cumparaturile') ?></a>
									<button onclick="finalizare_comanda();" id="btn_finalizare"  class="btn btn-globiz">
										<img src="<?= base_url() ?>assets/images/cart_w_check.png" class="cart-logo" title="cart"/> 
										<?= lang('finalizare_comanda') ?>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</section>