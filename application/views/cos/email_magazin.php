<h1 id="page-title"><?= lang('comanda') ?> <?= $comanda['id'] ?></h1>

<table class="comanda">
	<tr>
		<td><strong><?= lang('client') ?></strong></td>
		<td>
			<? if($tert['tip']==1): ?>
				<?= $tert['denumire'] ?>
			<? else: ?>
				<?= $tert['nume'] ?> <?= $tert['prenume'] ?>
			<? endif ?>
		</td>
	</tr>
	<tr>
		<td><strong>Data</strong></td>
		<td><?= date('d/m/Y', strtotime($comanda['data'])) ?></td>
	</tr>
	<tr>
		<td><strong><?= lang('adresa_livrare') ?></strong></td>
		<td><?= trim($adresa_livrare['adresa']) ?>, <?= $adresa_livrare['oras'] ?>, <?= $judete[$adresa_livrare['judet']] ?></td>
	</tr>
	<tr>
		<td><strong><?= lang('nota') ?></strong></td>
		<td><?= nl2br($comanda['observatii']) ?></td>
	</tr>
</table>
<br />
<table class="cart">
	<thead>
		<tr>
			<td class="cart-product"><?= lang('produs') ?>Produs</td>
			<td class="cart-qty"><?= lang('cantitate') ?>Cantitate</td>
			<td class="cart-price"><?= lang('pret_unitar') ?>Pret unitar</td>
			<td class="cart-price"><?= lang('suma_neta') ?>Suma neta</td>
			<td class="cart-price"><?= lang('suma_bruta') ?>Suma bruta</td>
		</tr>
	</thead>
	<tbody>
		<? $total = 0; $total_valoare = 0; ?>
	<? foreach($continut as $id => $c): ?>
		<tr id="<?= $id ?>">
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
			<td colspan="3"></td>
			<td class="total-line">
				<?= number_format($total_valoare,2) ?> <?= $comanda['moneda'] ?>
			</td>
			<td class="total-line">
				<?= number_format($total,2) ?> <?= $comanda['moneda'] ?>
			</td>
		</tr>
	</tfoot>
</table>