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
			<div class="col-sm-3 sidebar">
				<form action="<?= current_url() ?>" method="get" id="filtru_form">
				
					<!-- widget shop categories -->
					<? !isset($id_meniu)?$id_meniu = categorie_parinte():'' ?>
					<div class="shop-categories">
						<div class="title"><?= lang('categorii') ?></div>
						<div class="content">
							<?= meniu_stanga($id_meniu, 0, true,$produs['categorie_id'], $produs['categorie_id']) ?>
						</div>
					</div>

					<? if(isset($filtre) and count($filtre)): ?>
						<? foreach ($filtre as $atribut_id => $atribut): ?>
							<div class="shop-categories filtre">
								<h4><?= $atribut['atribut'] ?></h4>
								<div>
									<? foreach ($atribut['valori'] as $valoare_id => $valoare): ?>
									<div>
										<label>
											<input type="checkbox" name="atribut[<?= $atribut_id ?>][]" value="<?= $valoare_id ?>" <? if(isset($atribute_selectare[$atribut_id]) and in_array($valoare_id, $atribute_selectare[$atribut_id])): ?>checked<? endif ?> onchange="$('#filtru_form').submit()">
											<?= $valoare ?>
										</label>
									</div>
									<? endforeach?>
								</div>
							</div>
						<? endforeach ?>
					<? endif ?>
				</form>
			</div>
			<!-- CONTENT -->
			<div class="col-sm-9 mt10 product-item produs product_id_<?= $produs['id'] ?>" id="content">
				<div class="row  ">
					<div class="col-6">
						<div id="big" class="owl-carousel owl-theme">
							<? foreach ($imagini as $k => $i) : ?>
								<? $srcImg = $this->config->item('static_url').'680/680/'.$i['imagine'] ?>
								<? $srcLargeImg = $this->config->item('static_url').'680/680/'.$i['imagine'] ?>
								<div class="item">
									<div class="shadow img">
										<img class="img-responsive imgZoom"  data-zoom-image="<?= $srcLargeImg ?>" src="<?= $srcImg ?>" alt=""/>
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
						<? //print_r($produs) ?>
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
						<? if($produs['tip']==2): ?> <? //resigilat ?>
							<div class="resigilat">
							
							</div>
						<? elseif($stoc_limitat): ?>
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
					<div class="col-6">
						<div>
							<div class="breadcrumb mt-1">
								<i class="fa fa-angle-left"></i> <?= lang('back_to') ?> 
								<? foreach(categorie_tree($categorie_id, $categorie_id) as $c): ?>
									<?= $c ?>
								<? endforeach ?>
							</div>
							<div class="cod">
								<span><?= lang('cod_produs') ?> <?= $produs['cod'] ?></span>
							</div>
							<h1 class="mb-4"><?= $produs['denumire'.$this->session->userdata('fieldLang')]!=''?$produs['denumire'.$this->session->userdata('fieldLang')]:$produs['denumire'] ?></h1>
							<div class="row">
								<div class="col-5 text-center">
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
												<div class="btnGroup mt-3 product-btn ">
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
															<input class="cantitate" id="quantity_<?= $produs['id'] ?>"  data-min="<?= $produs['cantitate'] ?>"  data-step="<?= $produs['cantitate'] ?>" value="<?= $produs['cantitate'] ?>" title="<?= lang('buc') ?>" type="text" value="0" name="cantitate">
														<? else: ?>
															<input id="quantity_<?= $produs['id'] ?>" value="<?= $produs['cantitate'] ?>" title="<?= lang('buc') ?>" type="hidden" value="0" name="cantitate">
														<? endif ?>
													</div>
												</div>
											</div>
											<? if($in_precomanda): ?>
											<div style="text-align: justify;font-size: 13px;">
												<?= lang('text_precomanda') ?>
											</div>
											<? else: ?>
												<div>
													<? if(($in_stoc) or ($stoc_limitat)): ?>
														<?= lang('se_livreaza') ?>
														<strong>
														<? if($produs['in_stoc']): ?>
															24 <?= lang('ore') ?>
														<? else: ?>
															<? if($produs['stoc']>=1): ?>
															24 <?= lang('ore') ?>
															<? else: ?>
															48 <?= lang('ore') ?>
															<? endif ?>
														<? endif ?>
														</strong>
													<? endif ?>
												</div>
											<? endif ?>

										<? else: ?>
											<div class="stoc_precomanda text-center">
												<?= lang('produsul_nu_mai_face') ?>
											</div>
										<? endif ?>
									<? endif ?>
								</div>
								<div class="col-7">
									<table class="atribute table">
										<?
										foreach ($atribute as $atr) {
											if ($atr['valoare']){
												echo "<tr><td>".$atr['atribut']['atribut']."</td><td class='text-uppercase'>".$atr['valoare']['valoare'].'</td></tr>';
											}
										}?>
									</table>
								</div>
							</div>

							<? if($produs['video']!=''): ?>
								<div class="video">
									<video width="100%" controls>
										<source src="<?= $this->config->item('media_url').'video/'.$produs['video'] ?>" type="video/mp4">
										Your browser does not support the video tag.
									</video> 
								</div>
							<? endif ?>
						</div>
					</div>
				</div>
				<? if(str_replace("<p>&nbsp;</p>", "", $produs['descriere'.$this->session->userdata('fieldLang')]!=''?$produs['descriere'.$this->session->userdata('fieldLang')]:$produs['descriere'])!=''): ?>
				<div class="row mt-4 produs">
					<div class="col descriere">
						<div class="tab">
							<?= lang('Descriere') ?>
						</div>
						<div class="continut">
							<?= str_replace("<p>&nbsp;</p>", "", $produs['descriere'.$this->session->userdata('fieldLang')]!=''?$produs['descriere'.$this->session->userdata('fieldLang')]:$produs['descriere']) ?>
							<? if($produs['manual']!=''): ?>
							<hr />
							Descărcări<br />
							<a target="_blank" href="<?= $this->config->item('media_url').'manuale/'.$produs['manual'] ?>" style="display: inline-block;">
								<img src="<?= site_url('assets/images/pdf.png') ?>" width="50" style="vertical-align: top" /> Manual de utilizare
							 </a>
							<? endif ?>
						</div>
					</div>
				</div>
				<? endif ?>
				
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
								<div class="col-md-2dot4 col-sm-6 col-xs-6 product-list">
									<? $this->load->view('magazin/produs_lista_home', array('produs' => $p)) ?>
								</div>
							<? endforeach ?>
						</div>
					</div>
				</div>
				<? endif ?>
			</div>
		</div>
	<div class="clearfix"></div>
	</div>
</section>