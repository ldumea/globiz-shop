<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('Facturile mele') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 offset-md-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-md-8 col-sm-12 mt-sm-10">
				<form action="<?= site_url('utilizator/facturi') ?>" method="get">
	            	<div class="row">
	            		<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-users table-invoices">
									<thead>
									  <tr>
										<th><span><?= lang('Nr. factura') ?></span></th>
										<th><span><?= lang('data') ?></span></th>
										<th><span><?= lang('data_scandeta') ?></span></th>
										<th><span><?= lang('total') ?></span></th>
										<th><span><?= lang('stare') ?></span></th>
										<th width="150"></th>
									  </tr>
										  	<tr>
											  	<td>
											  		<input type="text" class="form-control" style="max-width: 100px;" name="numar" value="<?= $numar ?>">
											  	</td>
												<td>
													<div class="input-group" id="data_interval">
														<input type="text" class="form-control range" name="data" value="<?= $data ?>">
													</div>
												</td>
												<td></td>
												<td></td>
												<td>
													<?= form_dropdown('stare', $stari, $stare, 'class="form-control" style="max-width: 150px;"') ?>
												</td>
												<td>
													
													<button type="submit" class="btn btn-globiz btn-sm btn-shadow">
														<i class="fas fa-search"></i> Cauta
													</button>
												</td>
											</tr>
									</thead>
									<tbody>
									<? foreach($facturi as $f): ?>
									<tr>
										<td class="text-center">
											<a href="<?= site_url('utilizator/factura/'.$f['id']) ?>">
												<?= $f['serie'] ?><?= $f['numar'] ?>
											</a>
										</td>
										<td class="text-center"><?= date('d/m/Y', strtotime($f['data'])) ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($f['data_scadenta'])) ?></td>
										<td class="text-center"><?= $f['total'] ?> <?= $f['moneda'] ?></td>
										<td class="text-center">
											<? switch ($f['stare']) {
												case '2':
													$stare = $stari[2];
													$class_stare = 'label-success';
													break;
												case '3':
													$stare = $stari[3];
													$class_stare = 'label-warning';
													break;
												case '4':
													$stare = $stari[4];
													$class_stare = 'label-warning';
													break;
												default:
													$stare = $stari[1];
													$class_stare = 'label-danger';
													break;
											} ?>
											<span class="label <?= $class_stare ?> "><?= lang($stare) ?></span>
										</td>
										<td>
											<a href="<?= site_url('utilizator/factura/'.$f['id']) ?>" class="btn btn-sm btn-globiz">
												<i class="fa fa-eye"></i>&nbsp;Vizualizare 
											</a>
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