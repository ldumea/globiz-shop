<? if(count($produse)): ?>
	<? foreach ($produse as $p): ?>
	<div class="col-md-4 col-sm-6">
		<div class="product-item product_id_<?= $p['id'] ?>" id="product_group_<?= $p['id'] ?>">
		    <div class="text-center"><a href="<?= produs_url($p) ?>"><?= $p['cod'] ?></a></div>
		    <div class="thumbnail no-border no-padding">
		        <div class="media">
		        	<? if(count($p['imagine']) and $p['imagine']['imagine']!=''): ?>
						<? $src = $this->config->item('media_url') ?>
						<? $src.='articole/'.$p['imagine']['imagine'] ?>
						<a href="<?= produs_url($p) ?>" class="media-link">
							<img width="158" height="158" alt="" src="<?= $this->config->item('timthumb_url').'?src='.$src.'&w=263&h=189&zc=2' ?>" typeof="foaf:Image">
						</a>
					<? else: ?>
						<a href="<?= produs_url($p) ?>" class="media-link">
							<img width="158" height="158" alt="" src="<?= site_url('images/fara-imagine.gif') ?>" typeof="foaf:Image">
						</a>
					<? endif ?>	            
		        </div>
		        <div class="caption text-center">
		            <h4 class="caption-title"><a href="<?= produs_url($p) ?>" class="titlu-produs"><?= $p['denumire'.$this->session->userdata('fieldLang')]!=''?$p['denumire'.$this->session->userdata('fieldLang')]:$p['denumire'] ?></a></h4>
		            <? if(($p['stoc']!=0) or ($p['stoc_furnizor']!=0)):?>
						<div><?= lang('ambalaj') ?>: <?= $p['cantitate'] ?> <?= $p['um'] ?>.</div>
					<? endif ?>

					<? if(!$this->session->userdata('loggedFrontend')): ?>
						<div class="price"><ins>&nbsp;</ins></div>
					<? else: ?>
						<div class="price">
							<ins>
								<? if(($p['stoc']!=0) or ($p['stoc_furnizor']!=0)):?>
									<? if($this->config->item('blackfriday') and !($this->session->userdata('dropshipping'))): ?>
										<?= number_format($p['pret_vanzare']/$curs-(($p['pret_vanzare']*$p['maxDiscount'])/$curs)/100,2,",",".") ?> <?= $moneda ?>
									<? else: ?>
										<?= number_format($p['pret_vanzare']/$curs-(($p['pret_vanzare']*$p['discountVal'])/$curs)/100,2,",",".") ?> <?= $moneda ?>
									<? endif ?>
								<? endif ?>
							</ins>
							<!-- preti vechi mai mare -->
							<del>
								<? if(($p['stoc']!=0) or ($p['stoc_furnizor']!=0)):?>
									<? if($this->config->item('blackfriday') and !($this->session->userdata('dropshipping'))): ?>
										<? if($p['pret_intreg']>$p['pret_vanzare']): ?>
											<?= number_format($p['pret_intreg']/$curs,2,",",".") ?> <?= $moneda ?>
										<? else: ?>
											<?= number_format($p['pret_vanzare']/$curs,2,",",".") ?> <?= $moneda ?>
										<? endif ?>
									<? else: ?>
										<? if($p['pret_intreg']!=0): ?>
											<?= number_format($p['pret_intreg']/$curs,2,",",".") ?> <?= $moneda ?>
										<? endif ?>
									<? endif ?>
								<? endif ?>
							</del>
						</div>
						<? $in_stoc = false ?>
						<? $in_precomanda = false ?>
						<? if( ($p['stoc']==0) and ($p['stoc_furnizor']<15) and ($p['pret_furnizor']<2000)): ?>
							<? $in_precomanda = true ?>
							<div class="stoc_precomanda">
								<?= lang('precomanda') ?>
							</div>
						<? elseif($p['stoc']+$p['stoc_furnizor']<30): ?>
							<? $in_stoc = false ?>
							<div class="stoc_limitat">
								<?= lang('stoc_limitat') ?>
							</div>
						<? else: ?>
							<? $in_stoc = true ?>
							<div class="in_stoc">
								<?= lang('in_stoc') ?>
							</div>
						<? endif ?>

						<? if(!($this->config->item('blackfriday') and !($this->session->userdata('dropshipping')))): ?>
							<div class="reducere">
								<? if(!($this->session->userdata('discount')>0)): ?>
									<? if(($p['stoc']!=0) or ($p['stoc_furnizor']!=0)):?>
										<? if(count($discount)): ?>
											<table>
												<tr>
													<td>
														1-<?= $discount[0]['no_produse']-1 ?>
													</td>
													<? foreach ($discount as $key => $d): ?>
														<td>
															<? if(isset($discount[$key+1]['no_produse'])): ?>
																<? $next = $discount[$key+1]['no_produse']-1 ?>
															<? else: ?>
																<? $next = '+' ?>
															<? endif ?>
															<?= $d['no_produse'] ?>-<?= $next ?>
															
														</td>
													<? endforeach ?>
												</tr>
												<tr>
													<td>
														<?= number_format($p['pret_vanzare']/$curs, 2, ",", ".") ?>
													</td>
													<? foreach ($discount as $key => $d): ?>
														<td <?= $key==count($discount)-1?'class="orange"':'' ?>>
															<?= number_format(($p['pret_vanzare']/$curs)*(100-$d['discount'])/100, 2, ",", ".") ?>
															
														</td>
													<? endforeach ?>
												</tr>
											</table>
										<? endif ?>
									<? endif ?>
								<? endif ?>
							</div>
						<? endif ?>
						<div class="row text-center">
							<div class="buttons cart_form col-md-12">
								<? if(($p['stoc']!=0) or ($p['stoc_furnizor']!=0)):?>
									<input type="hidden" name="id" value="<?= $p['id'] ?>" />
									<span style="display: inline-block; line-height: 1; vertical-align: middle;">
										<? if($in_stoc): ?>
											<? if($p['stoc']>30): ?>
											<small><?= lang('se_livreaza') ?></small><br />
											24 <?= lang('ore') ?>
											<? else: ?>
											<small><?= lang('se_livreaza') ?></small><br />
											48 <?= lang('ore') ?>
											<? endif ?>
										<? endif ?>
									</span>
									<span class="quantity">
										<input class="form-control qty" type="text" step="<?= $p['cantitate'] ?>" min="<?= $p['cantitate'] ?>" name="cantitate" id="quantity_group<?= $p['id'] ?>" value="<?= $p['cantitate'] ?>" title="<?= lang('buc') ?>">
										<button class="btn plus" id="plus_group<?= $p['id'] ?>"><i class="fa fa-arrow-up"></i></button>
										<button class="btn minus" id="minus_group<?= $p['id'] ?>"><i class="fa fa-arrow-down"></i></button>
									</span>
									<button class="btn btn-theme btn-cart btn-icon-left" onclick="<? if($in_precomanda): ?>add_precomanda(this)<? else: ?>add_cart(this, false)<? endif ?>"><img src="<?= base_url().THEMESFOLDER .'images/adauga.png' ?>" width="45"></button>
								<? endif ?>
							</div>
						</div>
					<? endif ?>
		        </div>
		    </div>
		</div>
	</div>
	<? endforeach ?>
	<div class="clearfix"></div>	
<? endif ?>