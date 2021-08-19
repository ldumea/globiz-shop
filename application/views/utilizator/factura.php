<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('Factura') ?> <?= $factura['serie'] ?><?= $factura['numar'] ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 offset-md-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-md-7 col-sm-12 mt-sm-10">
            	<div class="row">
            		<div class="col-md-12">
						<div>
							<a href="javascript:void(0)" onclick="pdf_factura(<?= $factura['id'] ?>)" class="btn blue btn-warning">Listare</a>
							<a href="<?= site_url('utilizator/factura_excel/'.$factura['id']) ?>" class="btn btn-warning" style="background-color: #1DA06A; border-color: #1DA06A">Excel</a>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="row">
									<div class="col-md-4" style="margin-top: 0px;">Stare</div>
									<div class="col-md-8" style="margin-top: 0px;">
										<? switch ($factura['stare']) {
											case '2':
												$stare = $stari[2];
												$class_stare = 'div-success';
												break;
											case '3':
												$stare = $stari[3];
												$class_stare = 'div-warning';
												break;
											case '4':
												$stare = $stari[4];
												$class_stare = 'div-warning';
												break;
											default:
												$stare = $stari[1];
												$class_stare = 'div-danger';
												break;
										} ?>
										<span class="div <?= $class_stare ?> "><?= $stare ?></span>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4" style="margin-top: 0px;">Companie</div>
									<div class="col-md-8" style="margin-top: 0px;">
										<?= $factura['companie_nume'] ?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4" style="margin-top: 0px;">TVA</div>
									<div class="col-md-8" style="margin-top: 0px;">
										<?= $factura['companie_tva'] ?>%
									</div>
								</div>
								<div class="row">
									<div class="col-md-4" style="margin-top: 0px;">Data</div>
									<div class="col-md-8" style="margin-top: 0px;">
										<?= date('d/m/Y', strtotime($factura['data']))?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4" style="margin-top: 0px;">Data scadenta</div>
									<div class="col-md-8" style="margin-top: 0px;">
										<?= date('d/m/Y',strtotime($factura['data_scadenta']))?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4" style="margin-top: 0px;">Adresa livrare</div>
									<div class="col-md-8" style="margin-top: 0px;">
										<?= isset($adrese[$factura['tert_adresa_id']])?$adrese[$factura['tert_adresa_id']]:'' ?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4" style="margin-top: 0px;">Modalitate plata</div>
									<div class="col-md-8" style="margin-top: 0px;">
										<?= $modalitati_plata[$factura['modplata_id']] ?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4" style="margin-top: 0px;">Nota</div>
									<div class="col-md-8" style="margin-top: 0px;">
										<?= $factura['nota'] ?>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="row">
									<div class="control-div"><strong><?= $factura['tert_denumire'] ?></strong></div>
								</div>
								<div class="row">
									<div class="control-div">Telefon: <?= $tert['telefon'] ?></div>
								</div>
								<div class="row">
									<div class="control-div">Nr. reg. com.: <?= $factura['tert_reg_com'] ?></div>
								</div>
								<div class="row">
									<div class="control-div">Cod fiscal: <?= $factura['tert_cod_fiscal'] ?></div>
								</div>
								<div class="row">
									<div class="control-div">Sediul: 
										<?= $tara[$factura['tert_tara']] ?>
										<? if($factura['tert_judet']!=''): ?>, 
											<? if($factura['tert_tara']=='RO'): ?>
												<?= $judete[$factura['tert_judet']]?>
											<? else: ?>
												<?= $factura['tert_judet']?>
											<? endif ?>
										<? endif ?>
										<? if($factura['tert_oras']!=''): ?>, <?= $factura['tert_oras'] ?><? endif ?>
										, <?= $factura['tert_adresa']?>
										
										
									</div>
								</div>
								<div class="row">
									<div class="control-div">Cont: <?= $tert['cont_banca'] ?></div>
								</div>
								<div class="row">
									<div class="control-div">Banca: <?= $tert['banca'] ?></div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<hr/>
						<div class="table-responsive">
							<table id="tabel_comanda" class="table table-striped table-hover">
								<thead>
									<tr>
										<th>Articol</th>
										<th class="input-mini">UM</th>
										<th class="input-mini">TVA %</th>
										<th class="input-mini">Cantitate</th>
										<th class="input-mini">Pret unitar</th>
										<th class="input-mini">Valoare</th>
										<th class="input-mini">Total</th>
									</tr>
								</thead>
								<tbody>
									<? foreach($factura_continut as $l): ?>
									<tr  id="pozitie_<?= $l['id'] ?>">
										<td>
											<?= $l['cod'] ?> <?= $l['articol'] ?>
										</td>
										<td>
											<?= $l['um'] ?>
										</td>
										<td>
											<?= $l['tva'] ?>
										</td>
										<td>
											<?= $l['cantitate'] ?>
										</td>
										<td>
											<?= $l['pret_vanzare'] ?>
										</td>
										<td>
											<?= $l['valoare'] ?>
										</td>
										<td>
											<?= $l['total'] ?>
										</td>
									</tr>
									<? endforeach ?>
									
								</tbody>
								<tfoot></tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>