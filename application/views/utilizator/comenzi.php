<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('comenzile_mele') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 <? if($this->session->userdata('dropshipping')!=1): ?>offset-md-1<? endif ?>">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="<? if($this->session->userdata('dropshipping')==1): ?>col-md-9<? else: ?>col-md-8<? endif ?> col-sm-12 mt-sm-10">
				<form action="<?= site_url('utilizator/comenzi') ?>" method="get">
	            	<div class="row">
	            		<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-users">
									<thead>
									  	<tr>
											<th><span><?= lang('Nr. comanda') ?></span></th>
											<th><span><?= lang('data') ?></span></th>
											<th><span><?= lang('total') ?></span></th>
											<th><span><?= lang('stare') ?></span></th>
											<? if($this->session->userdata('dropshipping')==1): ?>
											<th><span><?= lang('AWB') ?></span></th>
											<th><span><?= lang('Factura') ?></span></th>
											<? endif ?>
											<th></th>
									  	</tr>
									  	<tr>
										  	<td>
										  		<input type="text" class="form-control" style="max-width: 100px;" name="comanda_id" value="<?= $comanda_id ?>">
										  	</td>
											<td>
												<div class="input-group" id="data_interval">
													<input type="text" class="form-control range" name="data" value="<?= $data ?>">
												</div>
											</td>
											<td></td>
											<td>
												<?= form_dropdown('stare', $stari, $stare, 'class="form-control" style="max-width: 150px;"') ?>
											</td>
											<? if($this->session->userdata('dropshipping')==1): ?>
											<td>
												<?= form_dropdown('stare_awb', $stari_document, $stare_awb, 'class="form-control" style="max-width: 150px;"') ?>
											</td>
											<td>
												<?= form_dropdown('stare_factura', $stari_document, $stare_factura, 'class="form-control" style="max-width: 150px;"') ?>
											</td>
											<? endif ?>
											<td>
												
												<button type="submit" class="btn btn-globiz btn-sm btn-shadow">
													<i class="fas fa-search"></i> Cauta
												</button>
											</td>
										</tr>
									</thead>
									<tbody>
									<? foreach($comenzi as $c): ?>
									<?
									$cls = '';
									if(($c['dropshipping']==1) and ($c['stare']==5)){
										if(($c['fisier_factura']=='') and ($c['fisier_awb']=='')){
											$cls = 'alert-danger';
										} elseif(($c['fisier_factura']!='') and ($c['fisier_awb']!='')){
											$cls = 'alert-success';
										} else{
											$cls = 'alert-warning';
										}
									}
									?>
									<tr>
										<td class="text-center <?= $cls ?>"><?= $c['id'] ?></td>
										<td class="text-center <?= $cls ?>"><?= date('d/m/Y', strtotime($c['data'])) ?></td>
										<td class="text-center <?= $cls ?>"><?= number_format($c['total'],2) ?> <?= $c['moneda'] ?></td>
										<td class="text-center <?= $cls ?>">
											<?
											switch ($c['stare']) {
												case '2': // 'Stand By'
												case '6': //'Produse HU'
												case '7': //'Supervizor'
												case '8': //'Factura proforma'
												case '3': //'Dispozitie de livrare'
													$stare = $stari[2];
													break;
												case '4': //'Anulata'
													$stare = $stari[4];
													break;
												case '5': //'Livrata'
													$stare = $stari[5];
													break;
												default: //'Noua'
													$stare = $stari[1];
													break;
											}
											?>
											<span class="stare ml20"><?= lang($stare) ?></span>
										</td>

										<? if($this->session->userdata('dropshipping')==1): ?>
										<td class="text-center <?= $cls ?>">
											<? if($c['dropshipping']==1): ?>
												<? if($c['fisier_awb']!=''): ?>
													incarcat
												<? else: ?>
													lipsa document
												<? endif ?>
											<? else: ?>
												-
											<? endif ?>
										</td>
										<td class="text-center <?= $cls ?>">
											<? if($c['dropshipping']==1): ?>
												<? if($c['fisier_factura']!=''): ?>
													incarcat
												<? else: ?>
													lipsa document
												<? endif ?>
											<? else: ?>
												-
											<? endif ?>
										</td>
										<? endif ?>
										<td>
											<a href="<?= site_url('utilizator/comanda/'.$c['id']) ?>" class="btn btn-globiz btn-sm btn-shadow">
												<i class="fa fa-eye"></i> Vizualizare
											</a>
											<? if(in_array($this->session->userdata('utilizator'), $this->config->item('utilizatori_test'))): ?>
												<? if($c['stare']!='4'): ?>
													<? if(!count($c['plata']) or (($c['plata']['cod_raspuns']!=2) and ($c['plata']['cod_raspuns']!=13) and ($c['plata']['cod_raspuns']!=3))): ?>
														<a href="<?= site_url('utilizator/plateste_comanda/'.$c['id']) ?>" class="btn btn-gray btn-sm btn-shadow">
															<i class="fa fa-credit-card"></i> <?= lang('plateste') ?>
														</a>
													<? endif ?>
												<? endif ?>
											<? endif ?>
										</td>
										</tr>
										<? endforeach ?>
									</tbody>
								</table>
							</div>
							<?= $pagini ?>
	            		</div>
	                </div>
	               
	        	</form>
	        </div>
            <!-- /CONTENT -->
        </div>
    </div>
</section>
<!-- /PAGE WITH SIDEBAR -->