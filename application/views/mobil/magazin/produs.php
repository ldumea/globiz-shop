<? $in_stoc = false ?>
<? $stoc_limitat = false ?>
<? $in_precomanda = false ?>
<? $class_stoc = ''; ?>
<? $text_stoc = ''; ?>
<? $pret_mare = 0 ?>
<? $pret_mic = 0 ?>
<? if($produs['in_stoc']): ?>
	<?
		$in_stoc = true;
		$class_stoc = 'in_stoc';
		$text_stoc = lang('in_stoc');
	?>
<? else: ?>
	<? if( ($produs['stoc']==0) and ($produs['stoc_furnizor']<15) and ($produs['pret_furnizor']<2000)): ?>
		<?
			$in_precomanda = true;
			$class_stoc = 'stoc_precomanda';
			$text_stoc = lang('precomanda');
		?>
	<? elseif( ($produs['stoc']==0) and ($produs['stoc_furnizor']==0) and ($produs['furnizor_id']==1)): ?>
		<?
			$in_precomanda = true;
			$class_stoc = 'stoc_precomanda';
			$text_stoc = lang('precomanda');
		?>
	<? elseif(($produs['stoc']+$produs['stoc_furnizor']==0) and ($produs['precomanda']==1)): ?>
		<?
			$in_precomanda = true;
			$class_stoc = 'stoc_precomanda';
			$text_stoc = lang('precomanda');
		?>
	<? elseif($produs['stoc']+$produs['stoc_furnizor']<30): ?>
		<?
			$in_stoc = false;
			$stoc_limitat = true;
			$class_stoc = 'stoc_limitat';
			$text_stoc = lang('stoc_limitat');
		?>
	<? else: ?>
		<?
			$in_stoc = true;
			$class_stoc = 'in_stoc';
			$text_stoc = lang('in_stoc');
		?>
	<? endif ?>
<? endif ?>
<section>
	<div class="container">
		<div class="row categorie">
			<div class="col-md-12 mt10 <? /*product-item*/ ?> product_id_<?= $produs['id'] ?>" id="content">
				<div class="row produs">
					<div class="col-12">
						<div class="cod">
							<span><?= lang('cod_produs') ?> <?= $produs['cod'] ?></span>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div id="big" class="owl-carousel owl-theme">
							<? foreach ($imagini as $k => $i) : ?>
								<? $srcImg = $this->config->item('static_url').'680/680/'.$i['imagine'] ?>
								<? $srcLargeImg = $this->config->item('static_url').'680/680/'.$i['imagine'] ?>
								<div class="item">
									<div class="shadow img">
										<img class="img-responsive"  data-zoom-image="<?= $srcLargeImg ?>" src="<?= $srcImg ?>" alt=""/>
									</div>
								</div>
							<? endforeach ?>	
						</div>
						<div id="thumbs" class="owl-carousel owl-theme">
							<? foreach ($imagini as $k => $i) : ?>
								<? $srcImg = $this->config->item('static_url').'200/200/'.$i['imagine'] ?>
								<div class="item shadow">
									<img class="img-responsive" src="<?= $srcImg ?>" alt=""/>
								</div>
							<? endforeach ?>
						</div>
						
						<? if($this->config->item('blackfriday') and !($this->session->userdata('dropshipping'))): ?>
							<? if($produs['pret_intreg']>$produs['pret_vanzare']): ?>
								<? $pret_mare = $produs['pret_intreg'] ?>
							<? else: ?>
								<? $pret_mare = $produs['pret_vanzare'] ?>
							<? endif ?>
							<? $pret_mic = $produs['pret_vanzare']-($produs['pret_vanzare']*$produs['maxDiscount'])/100 ?>
						<? else: ?>
							<? if( ($produs['pret_intreg']!=0) and ($produs['pret_intreg']>$produs['pret_vanzare']) ): ?>
								<? $pret_mare = $produs['pret_intreg'] ?>
							<? endif ?>
							<? $pret_mic = $produs['pret_vanzare'] ?>
						<? endif ?>
						<? if(($pret_mare != 0) && ($pret_mic!=0) && ($pret_mare > $pret_mic)): ?>
							<div class="procent_discount">
								<?= "-".round(100-($pret_mic/$pret_mare)*100)."%" ?>
							</div>
						<? endif ?>
						<? if($stoc_limitat): ?>
						<div class="stoc_limitat">
							
						</div>
						<? endif ?>
						
						<? if(count($imagini360)): ?>
							<? $i360 = $imagini360[0]; ?>
							<? $src = $this->config->item('media_url') ?>
							<? $src = 'https://crm.carguard.ro/media/' ?>
							<? $src.='articole_imagini360/'.$i360['id'].'/iframe.html' ?>
							<div class="img360">
								<a href="<?= $src ?>" class="fancyframe">
									<img src="<?= site_url() ?>assets/images/360.png" />
								</a>
							</div>
						<? endif ?>
					</div>
					<div class="col-md-6 col-sm-12">
						<h1 class="mb-4"><?= $produs['denumire'.$this->session->userdata('fieldLang')]!=''?$produs['denumire'.$this->session->userdata('fieldLang')]:$produs['denumire'] ?></h1>
						<div class="text-center">
							<? if($this->session->userdata('loggedFrontend')): ?>
								<? if( ($produs['activ']) and (($produs['stoc']+$produs['stoc_furnizor'])>0 or $produs['precomanda']==1 or ( ($produs['stoc']==0) and ($produs['stoc_furnizor']<15) and ($produs['pret_furnizor']<2000)))): ?>
									<div class="price">
										Pret:
										<strong>
										<? if($this->config->item('blackfriday') and !($this->session->userdata('dropshipping'))): ?>
											<?= number_format(($produs['pret_vanzare']/$curs)-(($produs['pret_vanzare']/$curs)*$produs['maxDiscount'])/100,2,",",".") ?> <?= $moneda ?>
										<? else: ?>
											<? if(($produs['pret_intreg']/$curs)>($produs['pret_vanzare']/$curs)): ?>
												<?= number_format(($produs['pret_vanzare']/$curs),2,",",".") ?> <?= $moneda ?>
											<? else: ?>
												<?= number_format(($produs['pret_vanzare']/$curs)-(($produs['pret_vanzare']/$curs)*$produs['discountVal'])/100,2,",",".") ?> <?= $moneda ?>
											<? endif ?>
										<? endif ?>
										</strong>
										<? if($this->config->item('blackfriday') and !($this->session->userdata('dropshipping'))): ?>
											<? if(($produs['pret_intreg']/$curs)>($produs['pret_vanzare']/$curs)): ?>
												<del><?= number_format(($produs['pret_intreg']/$curs),2,",",".") ?> <?= $moneda ?></del>
											<? else: ?>
												<? if((($produs['pret_vanzare']/$curs)-(($produs['pret_vanzare']/$curs)*$produs['maxDiscount'])/100) < ($produs['pret_vanzare']/$curs)): ?>
													<del><?= number_format(($produs['pret_vanzare']/$curs),2,",",".") ?> <?= $moneda ?></del>
												<? endif ?>
											<? endif ?>
										<? else: ?>
											<? if( (($produs['pret_intreg']/$curs)!=0) and (($produs['pret_intreg']/$curs)>($produs['pret_vanzare']/$curs)) ): ?>
												<del><?= number_format(($produs['pret_intreg']/$curs),2,",",".") ?> <?= $moneda ?></del>
											<? endif ?>
										<? endif ?>
									</div>
									<div class="ambalare">
										<?= lang('ambalaj') ?>: <strong><?= $produs['cantitate'] ?> <?= $produs['um'] ?></strong>
									</div>
									<? if(!($this->config->item('blackfriday') and !($this->session->userdata('dropshipping')))): ?>
										<? if( (($produs['pret_intreg']/$curs)!=0) and (($produs['pret_intreg']/$curs)>($produs['pret_vanzare']/$curs)) ): ?>
										<? else: ?>
											<? if( in_array($produs['furnizor_id'], $this->furnizori_asociati) or !($this->session->userdata('discount')>0)): ?>
												<? if(count($produs['discount'])): ?>
												<div class="mt-3">
													<?= lang('Pret / Cantitate') ?>
													<table class="reducere">
														<tr>
															<td>
																1-<?= $produs['discount'][0]['no_produse']-1 ?>
															</td>
															<? foreach ($produs['discount'] as $key => $d): ?>
																<td>
																	<? if(isset($produs['discount'][$key+1]['no_produse'])): ?>
																		<? $next = $produs['discount'][$key+1]['no_produse']-1 ?>
																	<? else: ?>
																		<? $next = '+' ?>
																	<? endif ?>
																	<?= $d['no_produse'] ?>-<?= $next ?>
																	
																</td>
															<? endforeach ?>
														</tr>
														<tr>
															<td>
																<?= number_format(($produs['pret_vanzare']/$curs), 2, ",", ".") ?>
															</td>
															<? foreach ($produs['discount'] as $key => $d): ?>
																<td <?= $key==count($produs['discount'])-1?'class="orange"':'' ?>>
																	<?= number_format(($produs['pret_vanzare']/$curs)*(100-$d['discount'])/100, 2, ",", ".") ?>
																	
																</td>
															<? endforeach ?>
														</tr>
													</table>
												</div>
												<? endif ?>
											<? endif ?>
										<? endif ?>
									<? endif ?>
									<div class="cart_form <? if($in_precomanda): ?>precomanda<? endif ?>">
										<div class="btnGroup mt-3 product-btn d-inline-block">
											<input type="hidden" name="id" value="<?= $produs['id'] ?>" />
											<button style="width: 100%; text-align: <? if($produs['tip']==1): ?>left<?else:  ?>center<?endif ?>;" class="btn btn-cart" onclick="<? if($in_precomanda): ?>add_precomanda(this)<? else: ?>add_cart(this)<? endif ?>" type="button">
												<? if($in_precomanda): ?>
												<?= lang('ANUNȚĂ-MĂ') ?>
												<? else: ?>
												<?= lang('ADAUGA IN COS') ?>
												<? endif ?>
											</button>
											<div class="input <? if($in_precomanda): ?>dn<? endif ?>">
												<? if($produs['tip']==1): ?>
													<input class="cantitate" id="quantity_<?= $produs['id'] ?>"  data-min="<?= $produs['cantitate'] ?>"  data-step="<?= $produs['cantitate'] ?>" value="<?= $produs['cantitate'] ?>" title="<?= lang('buc') ?>" type="text" name="cantitate">
												<? else: ?>
													<input id="quantity_<?= $produs['id'] ?>" value="<?= $produs['cantitate'] ?>" title="<?= lang('buc') ?>" type="hidden" name="cantitate">
												<? endif ?>
											</div>
										</div>
									</div>
								<? else: ?>
									<div class="stoc_precomanda text-center">
										<?= lang('produsul_nu_mai_face') ?>
									</div>
								<? endif ?>
							<? endif ?>
						</div>
						<? if(is_array($atribute) and count($atribute)): ?>
							<div>
								<table class="atribute table">
									<?
									foreach ($atribute as $atr) {
										if ($atr['valoare']){
											echo "<tr><td>".$atr['atribut']['atribut']."</td><td>".$atr['valoare']['valoare'].'</td></tr>';
										}
									}?>
								</table>
							</div>
						<? endif ?>
					</div>
					<div class="col-12">
						<? if(str_replace("<p>&nbsp;</p>", "", $produs['descriere'.$this->session->userdata('fieldLang')]!=''?$produs['descriere'.$this->session->userdata('fieldLang')]:$produs['descriere'])!=''): ?>
							<div class="row mt-4 produs">
								<div class="col descriere">
									<div class="tab">
										<?= lang('Descriere') ?>
									</div>
									<div class="continut">
										<?= str_replace("<p>&nbsp;</p>", "", $produs['descriere'.$this->session->userdata('fieldLang')]!=''?$produs['descriere'.$this->session->userdata('fieldLang')]:$produs['descriere']) ?>
									</div>
								</div>
							</div>
						<? endif ?>


						
					</div>
				</div>

				<? if (!empty($complementare)):?>
					<div class="row mt-4">
						<div class="col descriere">
							<div class="section-title">
								<span><?= lang('produse_complementare') ?></span>
								<div class="float-right product_scroller">
									
								</div>
							</div>
							<div class="row produse ">
								<? foreach ($complementare as $key => $p): ?>
									<div class="col-md-2dot4 col-6 product-list">
										<? $this->load->view('magazin/produs_lista_home', array('produs' => $p)) ?>
									</div>
								<? endforeach ?>
							</div>
						</div>
					</div>
				<? endif ?>

			</div>
		</div>
	</div>
</section>