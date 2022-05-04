<table class="table table-bordered">
	<thead>
		<tr>
			<th><?= lang('cod_produs') ?></th>
			<th><?= lang('poza') ?></th>
			<th width="30"><?= lang('cantitate') ?></th>
			<th><?= lang('produs') ?></th>
			<th><?= lang('Preț fără TVA') ?></th>
			<th class="hidden-cell"><?= lang('Preț cu TVA') ?></th>
			<th><?= lang('Valoare fără TVA') ?></th>
			<th><?= lang('Valoare cu TVA') ?></th>
		</tr>
	</thead>
	<tbody>
	<? $total = 0; ?>
	<? $subtotal = 0; ?>
	<? $total_fara_transport = 0; ?>
	<? foreach($cos as $id => $c): ?>
	<tr>
		<td class="text-center"><strong><?= $c['produs']['cod'] ?></strong></td>
		<td>
		<? if( isset($c['produs']['imagine']['imagine']) and ($c['produs']['imagine']['imagine']!='')): ?>                        
			<? $src = $this->config->item('media_url') ?>
			<? $src.='articole/'.$c['produs']['imagine']['imagine'] ?>
			<a href="<?= $c['url'] ?>">
				<img alt="" src="<?= $this->config->item('static_url').'100/100/'.$c['produs']['imagine']['imagine'] ?>">
			</a>
		<? endif ?>
		</td>
		<td class="quantity">
			<?if($c['produs']['tip']==1): ?>
				<input class="cantitate" type="number"  onchange="actualizeaza_cos('<?= $id ?>')" name="qty[<?= $id ?>]" data-min="<?= $c['produs']['cantitate'] ?>"  data-step="<?= $c['produs']['cantitate'] ?>" id="qty_<?= $id ?>" value="<?= $c['qty'] ?>" <? if(isset($c['options']['tip']) and ($c['options']['tip'] == 'produs_cadou')): ?> readonly<? endif ?>>
			<? else: ?>
				<?= $c['qty'] ?>
			<? endif ?>
		</td>
		<td>
			<a href="<?= $c['url'] ?>">
				<?= convert_accented_characters($c['name']) ?>
			</a>
			<? if(isset($c['options']['ecotaxa']) and ($c['options']['ecotaxa']!=0)): ?>
			<small>Taxa Eco este inclusa in pret in suma de <?= round($c['options']['ecotaxa'],2) ?> / buc.</small>
			<? endif ?>
			<? if(isset($c['options']['furnizor_id']) and in_array($c['options']['furnizor_id'], $this->furnizori_asociati)): ?>
			<small>Produsul are transportul gratuit.</small>
			<? endif ?>
		</td>
		<td class="text-right text-nowrap"><strong><?= number_format(round($c['price'],2),2) ?> <?= $moneda ?></strong></td>
		<td class="text-right text-nowrap hidden-cell">
			<strong><?= number_format($c['price']*(100+$c['tva'])/100,2) ?> <?= $moneda ?></strong>
		</td>
		<td class="text-right text-nowrap"><strong><?= number_format($c['subtotal'],2) ?> <?= $moneda ?></strong></td>
		<td  class="text-right text-nowrap">
			<? $total+=$c['subtotal']*(100+$c['tva'])/100?>
			<? if(!(isset($c['options']['furnizor_id']) and in_array($c['options']['furnizor_id'], $this->furnizori_asociati))): ?>
				<? $total_fara_transport += $c['subtotal']*(100+$c['tva'])/100 ?>
			<? endif ?>
			<? $subtotal+=$c['subtotal'] ?>
			<strong><?= number_format($c['subtotal']*(100+$c['tva'])/100,2) ?> <?= $moneda ?></strong>
			<? if(!(isset($c['options']['tip']) and ($c['options']['tip'] == 'produs_cadou'))): ?>
				<a href="javascript:;" class="btn btn-outline-globiz" onclick="stergeProdus('<?= $id ?>')"><i class="fas fa-times"></i></a>
			<? endif ?>
		 </td>
	</tr>                    
	<? endforeach ?>
	
	<? if(count($discount)) :?>
	<tr>
		<td colspan="4"><?= $discount['name'] ?></td>
		<td class="text-right text-nowrap"><strong><?= number_format(round($discount['price'],2),2) ?> <?= $moneda ?></strong></td>
		<td class="text-right text-nowrap"><strong><?= number_format($discount['price']*(100+$this->session->userdata('valoare_tva'))/100,2) ?> <?= $moneda ?></strong></td>
		<td class="text-right text-nowrap"><strong><?= number_format($discount['subtotal'],2) ?> <?= $moneda ?></strong></td>
		<td  class="text-right text-nowrap">
			<strong><?= number_format($discount['subtotal']*(100+$discount['tva'])/100,2) ?> <?= $moneda ?></strong>
			<? $total += $discount['subtotal']*(100+$discount['tva'])/100 ?>
			<? $total_fara_transport += $discount['subtotal']*(100+$discount['tva'])/100 ?>
		</td>
	</tr>
	<? endif ?>
	<? if(count($discount_produs_cadou)) :?>
	<tr>
		<td colspan="4"><?= $discount_produs_cadou['name'] ?></td>
		<td class="text-right text-nowrap"><strong><?= number_format(round($discount_produs_cadou['price'],2),2) ?> <?= $moneda ?></strong></td>
		<td class="text-right text-nowrap"><strong><?= number_format($discount_produs_cadou['price']*(100+$discount_produs_cadou['tva'])/100,2) ?> <?= $moneda ?></strong></td>
		<td class="text-right text-nowrap"><strong><?= number_format($discount_produs_cadou['subtotal'],2) ?> <?= $moneda ?></strong></td>
		<td  class="text-right text-nowrap">
			<strong><?= number_format($discount_produs_cadou['subtotal']*(100+$discount_produs_cadou['tva'])/100,2) ?> <?= $moneda ?></strong>
			<? $total += $discount_produs_cadou['subtotal']*(100+$discount_produs_cadou['tva'])/100 ?>
			<? $total_fara_transport += $discount_produs_cadou['subtotal']*(100+$discount_produs_cadou['tva'])/100 ?>
		</td>
	</tr>
	<? endif ?>
	<? if(count($voucher)) :?>
	<tr>
		<td colspan="4"><?= $voucher['name'] ?></td>
		<td class="text-right text-nowrap"><strong><?= number_format(round($voucher['price'],2),2) ?> <?= $moneda ?></strong></td>
		<td class="text-right text-nowrap"><strong><?= number_format($voucher['price']*(100+$this->session->userdata('valoare_tva'))/100,2) ?> <?= $moneda ?></strong></td>
		<td class="text-right text-nowrap"><strong><?= number_format($voucher['subtotal'],2) ?> <?= $moneda ?></strong></td>
		<td  class="text-right text-nowrap">
			<strong><?= number_format($voucher['subtotal']*(100+$voucher['tva'])/100,2) ?> <?= $moneda ?></strong>
			<? $total += $voucher['subtotal']*(100+$voucher['tva'])/100 ?>
			<? $total_fara_transport += $voucher['subtotal']*(100+$voucher['tva'])/100 ?>
			
			<a onclick="stergeProdus('<?= $voucher['rowid'] ?>')" href="javascript:void(0)"  class="btn btn-outline-globiz"><i class="fas fa-times"></i></a>
		</td>
	</tr>
	<? endif ?>
	
	<? if($tara == 'RO'): ?>
		<? if(count($transport)) :?>
		<tr>
			<td colspan="4"><?= $transport['name'] ?></td>
			<td class="text-right text-nowrap"><strong><?= number_format(round($transport['price'],2),2) ?> <?= $moneda ?></strong></td>
			<td class="text-right text-nowrap"><strong><?= number_format($transport['price']*(100+$this->session->userdata('valoare_tva'))/100,2) ?> <?= $moneda ?></strong></td>
			<td class="text-right text-nowrap"><strong><?= number_format($transport['subtotal'],2) ?> <?= $moneda ?></strong></td>
			<td  class="text-right text-nowrap">
				<strong><?= number_format($transport['subtotal']*(100+$transport['tva'])/100,2) ?> <?= $moneda ?></strong>
				<? $total += $transport['subtotal']*(100+$transport['tva'])/100 ?>
			</td>
		</tr>
		<? endif ?>
	<? else: ?>
		<tr>
			<td colspan="4"><?= lang('transport') ?></td>
			<td colspan="4">
				<? if($total_fara_transport < $cos_transport): ?>
					<?= lang('transport1') ?>
				<? else: ?>
					<?= lang('transport2') ?>
				<? endif ?>
			</td>
		</tr>
	<? endif ?>
	
	</tbody>
</table>
<? if(($this->config->item('afisare_mesaj_cos')==1) and ($total_fara_transport<$this->config->item('suma_mesaj_cos'))): ?>
    
    <?
    
    $_data['diferenat_pt_cadou'] = number_format($this->config->item('suma_mesaj_cos') - $total_fara_transport, 2);
    $mesaj = $this->config->item('mesaj_cos');
    echo $this->parser->parse_string($mesaj, $_data, true);
    ?>
<? endif ?>
<? if($this->session->userdata('dropshipping')!=1): ?>
    <? if($total_fara_transport < $cos_transport): ?>
        
        <div class="alert alert-warning">
            <? if($total_fara_transport>0): ?>
                <?= lang('text_transport1') ?><b><?= number_format($cos_transport - $total_fara_transport, 2)?></b> lei <?= lang('text_transport2') ?>.
            <? else: ?>
                <?= lang('text_transport3') ?>
            <? endif ?>
        </div>
    
    <? endif ?>
<? endif ?>

<? // 5D5FE72C25265 ?>
<table class="table table-bordered">
	<tr>
		<td class="text-center">
			<table class="d-inline-block">
				<tr class="table-border-bottom">
					<td class="text-left">
						<span class="text-uppercase"><?= lang('Total coș de cumpărături') ?></span> <strong><?= number_format($total,2) ?> <?= $moneda ?></strong>
					</td>
				</tr>
				<? if(!(isset($voucher) and (count($voucher)))): ?>
				<tr>
					<td class="text-left">
						<span class="text-uppercase"><?= lang('Adăugaţi un cod de reducere') ?></span><br />
						<div id="error_cupon"></div>
						<form id="form-cupon" action="" method="post" class="form-inline">
							
							<input class="form-control" type="text" name="voucher"/>
							<button type="button" class="btn btn-dark d-block ml-1" onclick="adauga_cupon()"><?= lang('adauga') ?></button>
						</form>
					</td>
				</tr>
				<? endif ?>
				<tr>
					<td>
						<a href="<?= site_url('cos/finalizare_comanda') ?>" class="btn btn-globiz d-block"><?= lang('finalizare_comanda') ?></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div class="row">
	<div class="col">
		<? if($total_fara_transport < $suma_produse_cadou): ?>
			<? if(count($produse_cadou)): ?>
				<div class="alert alert-warning">
					<p>
					<? if($total_fara_transport>0): ?>
						<?= lang('text_transport1') ?><b><?= number_format($suma_produse_cadou - $total_fara_transport, 2)?></b> beneficiezi de 
						<span class="text-uppercase">
							<strong class="color1">
								<? if(count($produse_cadou)==1): ?>
									1 PRODUS CADOU
									<?
										$pcod = $produse_cadou[0];
										$produs = $this->magazin_db->produs(array('cod' => $pcod));
									?>
									- 
									<? if($produs['cantitate']>1): ?>
										SET <?= $produs['cantitate'] ?> <?= $produs['um'] ?>
									<? endif ?><?= $produs['denumire'] ?>
								<? else: ?>
									CELE <?= count($produse_cadou) ?> PRODUSE CADOU
								<? endif ?>
							</strong>
						</span>
					<? else: ?>
						<?= lang('text_transport3') ?>
					<? endif ?>
					</p>
				</div>
			<? endif ?>
		<? endif ?>
	</div>
</div>