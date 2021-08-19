<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('comanda') ?> <?= $comanda['id'] ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 offset-md-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-md-8 col-sm-12 mt-sm-10">
			<?
			switch ($comanda['stare']) {
				case '2': // 'Stand By'
				case '6': //'Produse HU'
				case '7': //'Supervizor'
				case '8': //'Factura proforma'
				case '3': //'Dispozitie de livrare'
					$stare = 'Spre livrare';
					break;
				case '4': //'Anulata'
					$stare = 'Anulata';
					break;
				case '5': //'Livrata'
					$stare = 'Livrata';
					break;
				default: //'Noua'
					$stare = 'Neprocesata';
					break;
			}
			?>
            	<div class="row">
            		<div class="col-12">
            			<h4 class="block-title"><span><?= lang('comanda') ?></span></h4>  
            			<div class="row">
                        	<div class="col">
		                        <div class="media-body">
			                        <strong><?= lang('stare') ?>:</strong><br>
			                        <?= $stare ?>
			                    </div>
		                    </div>
		                    <div class="col">
		                        <div class="media-body">
			                        <strong><?= lang('data') ?>:</strong><br>
			                        <?= date('d/m/Y', strtotime($comanda['data'])) ?>
			                    </div>
		                    </div>
							<? if($comanda['dropshipping']!=1): ?>
		                    <div class="col">
		                        <div class="media-body">
			                        <strong><?= lang('adresa_livrare') ?>:</strong><br>
			                        <?= $tara[$adresa_livrare['tara']]?>, 
			                        <? if($adresa_livrare['tara'] == 'RO'): ?>
			                        	<?= $judete[$adresa_livrare['judet']] ?>,
			                        <? else: ?>
			                        	<?= $adresa_livrare['judet'] ?>,
			                        <? endif ?>
			                        <?= $adresa_livrare['oras'] ?>, <?= $adresa_livrare['adresa'] ?>
			                    </div>
		                    </div>
							<? endif ?>
						</div>
						<div class="row">
		                    <div class="col">
		                        <div class="media-body">
			                        <strong><?= lang('nota') ?>:</strong><br>
			                        <?= nl2br($comanda['nota']) ?>
			                    </div>
		                    </div>
						</div>
					</div>
					<div class="col-12">
						<h4 class="block-title"><span><?= lang('produse_comandate') ?></span></h4>
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
								  <tr>
									<th><?= lang('poza') ?></th>
									<th><?= lang('produs') ?></th>
									<th><?= lang('cantitate') ?></th>
									<th><?= lang('pret_unitar') ?></th>
									<th><?= lang('suma_neta') ?></th>
									<th><?= lang('suma_bruta') ?></th>
								  </tr>
								</thead>
								<tbody>
								<? $total = 0; $total_valoare = 0; ?>
								<? foreach($continut as $id => $c): ?>
									<tr id="<?= $id ?>">
										<td>
											<a href="<?= produs_url($c['produs']) ?>">
												<? if(isset($c['imagine']['imagine']) and ($c['imagine']['imagine']!='')): ?>
													<? $src = $this->config->item('media_url') ?>
													<? $src.='articole/'.$c['imagine']['imagine'] ?>
													<img width="40" height="40" alt="" src="<?= $this->config->item('timthumb_url').'?src='.$src.'&w=40&h=40&zc=1' ?>" typeof="foaf:Image">
												<? endif ?>
											</a>
										</td>
										<td>
											<a href="<?= produs_url($c['produs']) ?>">
												<?= $c['articol'] ?>
											</a>
										</td>
										<td>
											<?= $c['cantitate'] ?>
										</td>
										<td class="cart-row-price">
											<?= number_format($c['pret_vanzare'],2) ?> <?= $comanda['moneda'] ?>
										</td>
										<td class="cart-row-price">
											<? $total_valoare+=$c['valoare']?>
											<?= number_format($c['valoare'],2) ?> <?= $comanda['moneda'] ?>
										</td>
										<td class="cart-row-price">
											<? $total+=$c['total'] ?>
											<?= number_format($c['total'],2) ?> <?= $comanda['moneda'] ?>
										</td>
									</tr>
								<? endforeach ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4"></td>
										<td class="total-line" >
											<strong><?= number_format($total_valoare,2) ?> <?= $comanda['moneda'] ?></strong>
										</td>
										<td class="total-line">
											<strong><?= number_format($total,2) ?> <?= $comanda['moneda'] ?></strong>
										</td>
									</tr>
								</tfoot>
							</table>
						</div>
						<? if(($comanda['dropshipping']==1)): ?>
						<form action="<?= current_url() ?>" method="post" enctype="multipart/form-data">
							<div class="media mt-3">
								<div class="media-body">
									<strong>Factura:</strong>
									<? if($comanda['fisier_factura']==''): ?>
									<input type='file' name="fisier_factura" />
									<? else: ?>
									<a href="<?= $this->config->item('media_url').'terti/'.$comanda['fisier_factura'] ?>" target="_blank"><?= $comanda['fisier_factura'] ?></a>
									<? endif ?>
								</div>
							</div>
							<div class="media mt-3">
								<div class="media-body">
									<strong>AWB:</strong>
									<? if($comanda['fisier_awb']==''): ?>
									<input type='file' name="fisier_awb" />
									<? else: ?>
									<a href="<?= $this->config->item('media_url').'terti/'.$comanda['fisier_awb'] ?>" target="_blank"><?= $comanda['fisier_awb'] ?></a>
									<? endif ?>
								</div>
							</div>
							<? if(($comanda['fisier_awb']=='') or ($comanda['fisier_factura']=='')): ?>
							<div class="media mt-3">
								<button class="btn btn-globiz btn-shadow">Actualizeaza</button>
							</div>
							<? endif ?>
						</form>
						<? endif ?>
					</div>	
                </div>
				<? if(in_array($this->session->userdata('utilizator'), $this->config->item('utilizatori_test'))): ?>
					<? if($comanda['stare']!='4'): ?>
						<? if(!count($comanda['plata']) or (($comanda['plata']['cod_raspuns']!=2) and ($comanda['plata']['cod_raspuns']!=13) and ($comanda['plata']['cod_raspuns']!=3))): ?>
							<a href="<?= site_url('utilizator/plateste_comanda/'.$comanda['id']) ?>" class="btn btn-primary btn-sm">
								<span class="glyphicon glyphicon-credit-card"></span> <?= lang('plateste') ?>
							</a>
						<? endif ?>
					<? endif ?>
				<? endif ?>
            </div>
            <!-- /CONTENT -->
            <div class="col-md-9">
			  	
			</div>
        </div>
    </div>
</section>
<!-- /PAGE WITH SIDEBAR -->