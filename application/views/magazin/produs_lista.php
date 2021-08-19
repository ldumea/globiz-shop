<? $in_stoc = false ?>
<? $stoc_limitat = false ?>
<? $in_precomanda = false ?>
<? $class_stoc = ''; ?>
<? $text_stoc = ''; ?>
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
<div class="text-center product-item product_id_<?= $produs['id'] ?>">
	<div class="product-content">
		<div class="cod"><?= $produs['cod'] ?></div>
		<div>
			<a href="<?= produs_url($produs) ?>">
				<? if(count($produs['imagine']) and $produs['imagine']['imagine']!=''): ?>
					<? $src = $this->config->item('static_url').'201/201/'.$produs['imagine']['imagine'] ?>
					<? $src2 = $this->config->item('static_url').'201/201/'.$produs['imagine2']['imagine'] ?>
					<img class='img-fluid product-image' src="<?= $src ?>" data-image-second="<?= $src2 ?>"  >
				<? else: ?>
					<img class='img-fluid' alt="" src="<?= site_url('images/fara-imagine.gif') ?>">
				<? endif ?>
				<? /*
				<? if($this->config->item('blackfriday')): ?>
					<? if($this->config->item('imagine_reducere')!=''): ?>
						<div class="tag_reducere">
							<img src="<?= site_url($this->config->item('imagine_reducere')) ?>" />
						</div>
					<? endif ?>
				<? endif ?>
				*/ ?>
			</a>
		</div>
		<div class="box">
			<div class="caption">
				<a href="<?= produs_url($produs) ?>"><?= $produs['denumire'.$this->session->userdata('fieldLang')]!=''?$produs['denumire'.$this->session->userdata('fieldLang')]:$produs['denumire'] ?></a>
			</div>
			<? if($this->session->userdata('loggedFrontend')): ?>
				<? $pret_mare = 0 ?>
				<? $pret_mic = 0 ?>
				<div class="price">
					<? if($this->config->item('blackfriday')): ?>
						<?= number_format(($produs['pret_vanzare']/$curs)-(($produs['pret_vanzare']/$curs)*$produs['maxDiscount'])/100,2,",",".") ?> <?= $moneda ?>
					<? else: ?>
						<?= number_format(($produs['pret_vanzare']/$curs)-(($produs['pret_vanzare']/$curs)*$produs['discountVal'])/100,2,",",".") ?> <?= $moneda ?>
					<? endif ?>
					<del>
						<? if($this->config->item('blackfriday')): ?>
							<? if(($produs['pret_intreg']/$curs)>($produs['pret_vanzare']/$curs)): ?>
								<?= number_format(($produs['pret_intreg']/$curs),2,",",".") ?> <?= $moneda ?>
							<? else: ?>
								<? if((($produs['pret_vanzare']/$curs)-(($produs['pret_vanzare']/$curs)*$produs['maxDiscount'])/100) < ($produs['pret_vanzare']/$curs)): ?>
									<?= number_format(($produs['pret_vanzare']/$curs),2,",",".") ?> <?= $moneda ?>
								<? endif ?>
							<? endif ?>
						<? else: ?>
							<? if( (($produs['pret_intreg']/$curs)!=0) and (($produs['pret_intreg']/$curs)>($produs['pret_vanzare']/$curs)) ): ?>
								<?= number_format(($produs['pret_intreg']/$curs),2,",",".") ?> <?= $moneda ?>
							<? endif ?>
						<? endif ?>
					</del>
				</div>
				<div class="info">
					<div class="hover"><?= lang('ambalaj') ?>: <b><?= $produs['cantitate'] ?> <?= $produs['um'] ?></b></div>
					<div class="hover">
						<? if(!$this->config->item('blackfriday')): ?>
							<? if( (($produs['pret_intreg']/$curs)!=0) and (($produs['pret_intreg']/$curs)>($produs['pret_vanzare']/$curs)) ): ?>
								<div style="height: 59px;" class="display-mobile"></div>
							<? else: ?>
								<? if( in_array($produs['furnizor_id'], $this->furnizori_asociati) or !($this->session->userdata('discount')>0)): ?>
									<? if(count($produs['discount'])): ?>
									<div>
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
					</div>
					<div class="cart_form <? if($in_precomanda): ?>precomanda<? endif ?>">
						<div class="btnGroup">
							<input type="hidden" name="id" value="<?= $produs['id'] ?>" />
							<button style="width: 100%; text-align: left;" class="btn btn-cart" onclick="<? if($in_precomanda): ?>add_precomanda(this)<? else: ?>add_cart(this)<? endif ?>" type="button">
								<? if($in_precomanda): ?>
								<?= lang('ANUNȚĂ-MĂ') ?>
								<? else: ?>
								<?= lang('ADAUGA IN COS') ?>
								<? endif ?>
							</button>
							<div class="input <? if($in_precomanda): ?>dn<? endif ?>">
								<input class="cantitate" id="quantity_<?= $produs['id'] ?>"  data-min="<?= $produs['cantitate'] ?>"  data-step="<?= $produs['cantitate'] ?>" value="<?= $produs['cantitate'] ?>" title="<?= lang('buc') ?>" type="text" value="0" name="cantitate">
							</div>
						</div>
					</div>
					<div class="hover">
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
				</div>
				<? if($this->config->item('blackfriday')): ?>
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
				<? if($this->config->item('blackfriday')):?>
					<? if(round(100-($pret_mic/$pret_mare)*100)!=0): ?>
						<div class="procent_discount_blackfriday">
							<?= "-".round(100-($pret_mic/$pret_mare)*100)."%" ?>
						</div>
					<? endif ?>
				<? else: ?>
					<? if(($pret_mare != 0) && ($pret_mic!=0) && ($pret_mare > $pret_mic)): ?>
						<div class="procent_discount">
							<?= "-".round(100-($pret_mic/$pret_mare)*100)."%" ?>
						</div>
					<? endif ?>
				<? endif ?>
				<? if($stoc_limitat): ?>
				<div class="stoc_limitat">
					
				</div>
				<? endif ?>
			<? endif ?>
		</div>
	</div>
</div>