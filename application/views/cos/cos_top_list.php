<?
	$cart = $this->cart->contents();
    //print_R($cart);
    $cos = array();
    $transport = array();
	$discount = array();
	$voucher = array();
    $total = 0;
    if (count($cart))
    {
        foreach($cart as $k=>$c){
            $produs = $this->magazin_db->produs(array('id' => $c['id']));
            if(count($produs)){
                $produs['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $produs['id']), array('ordine' => 'asc'));
                $cos[$k] = $c;
                $cos[$k]['url'] = produs_url($produs);
                $cos[$k]['produs'] = $produs;
                // if(isset($c['options']['ecotaxa']) and ($c['options']['ecotaxa']!=0))
                //     $total+=$c['options']['ecotaxa']*$c['qty'];
				
				$total+=$c['subtotal'];
            }
			switch($c['id']){
				case 'transport':
					$transport = $c;
					break;
				case 'discount':
					$discount = $c;
					break;
				case 'voucher':
					$voucher = $c;
					break;
            }
			
            //$total+=$c['subtotal'];
			//$total+=$c['subtotal']*(100+$this->session->userdata('valoare_tva'))/100;
        }
	}
	$total_cos = $total;
?>
<div class="shopping-cart-items">
<? if(count($cos)): ?>
<table>
	<? foreach($cos as $id => $c): ?>
	<tr>
		<td style="vertical-align: top">
			<a href="<?= $c['url'] ?>" class=" item-image">
				<? if(isset($c['produs']['imagine']['imagine']) and ($c['produs']['imagine']['imagine']!='')): ?>
					<? $src = $this->config->item('media_url') ?>
					<? $src.='articole/'.$c['produs']['imagine']['imagine'] ?>
					<img alt="" src="<?= $this->config->item('static_url').'50/50/'.$c['produs']['imagine']['imagine'] ?>">
				<? endif ?>
			</a>
		</td>
		<td>
			<span class="item-name"><?= lang('Cod') ?>: <?= $c['produs']['cod'] ?></span>
			<span class="item-name"><a href="<?= $c['url'] ?>"><?= $c['name'] ?></a></span>
			<span class="item-price">
				<?= number_format(round($c['price'],2),2) ?> <?= $moneda ?>
			</span>
			<span class="item-qty">
				Cantitate: <?= $c['qty'] ?> <?= $c['produs']['um'] ?>
			</span>
		</td>
		<td style="vertical-align: middle">
			<a href="javascript:;" class="btn" onclick="stergeProdus('<?= $id ?>')"><i class="fas fa-times"></i></a>
		</td>
	</tr>
	<? endforeach ?>
</table>
<? else: ?>
	<div class="py-2 px-2"><?= lang('cosul_este_gol') ?></div>
<? endif ?>
</div>
<hr class="gray">
<div class="summary">
<div>
	<div>
		<div class="float-left"><?= lang('Valoare comenzii') ?></div>
		<div class="float-right"><?= number_format($total_cos,2,",",".") ?> <?= $moneda ?></div>
			<div class="clearfix"></div>
		</div>
		<? if(count($discount)) :?>
		<div>
			<div class="float-left"><?= $discount['name'] ?></div>
			<div class="float-right"><?= number_format($discount['subtotal'],2,",",".") ?> <?= $moneda ?></div>
			<div class="clearfix"></div>
		</div>	
			<? $total = $total+$discount['subtotal']; ?>
		<? endif ?>
		<? if(count($voucher)) :?>
		<div>
			<div class="float-left"><?= $voucher['name'] ?></div>
			<div class="float-right"><?= number_format($voucher['subtotal'],2,",",".") ?> <?= $moneda ?></div>
			<div class="clearfix"></div>
		</div>	
			<? $total = $total+$voucher['subtotal']; ?>
		<? endif ?>
		<? if(count($transport)) :?>
		<div>
			<div class="float-left"><?= $transport['name'] ?></div>
			<div class="float-right"><?= number_format($transport['subtotal'],2,",",".") ?> <?= $moneda ?></div>
			<div class="clearfix"></div>
		</div>	
			<? $total = $total+$transport['subtotal']; ?>
		<? endif ?>
	</div>
	<hr class="gray"/>
	<div>
		<? if(count($cos)): ?>
		<div>
			<div class="float-left"><?= lang('total') ?></div>
			<div class="float-right"><b><?= number_format($total,2,",",".") ?> <?= $moneda ?></b></div>
		</div>
		<div class="clearfix"></div>
		<a href="<?= site_url('cos/finalizare_comanda') ?>" class="btn btn-globiz d-block"><?= lang('Finalizare comanda') ?></a>
		<a href="<?= site_url('cos') ?>" class="btn btn-outline-dark d-block"><?= lang('Cos de cumparaturi') ?></a>
		<? endif ?>
	</div>
	<div class="clearfix"></div>
</div>