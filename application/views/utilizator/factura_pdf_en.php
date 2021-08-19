<!DOCTYPE html>
<html>
    <head>
		<title>Factura - <?= $factura['serie'] ?><?= $factura['numar'] ?></title>
		<meta charset="utf-8">
		<script>
		
		</script>
		<style>
			body {
			    margin:     0cm;
			    padding:    0cm;
			    font-family: Helvetica;
			    font-size: 13px;
			    width: 21cm;
			    height: 29.7cm;
			}
			table, caption, tbody, tfoot, thead, tr, th, td {margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent}
			table {border-collapse:collapse;border-spacing:0}
			.continut{
				width: 100%;
				border-collapse: collapse;
		    	border-spacing: 0;
				font-size: 12px;
			}
			.continut th{font-weight: bold; border: 1px solid #000;}
			.continut .border td, .continut .border th{border: 1px solid #000;margin: 0; padding: 2px;}
			
			.subsol{
				width: 100%;
				border-collapse: collapse;
		    	border-spacing: 0;
			}
			.subsol th{font-weight: bold; border: 1px solid #000;}
			.subsol td, .subsol th{border: 1px solid #000;margin: 0; padding: 7px; /*font-size: 11px;*/}
			.subsol small{font-size: 8px;display: inline-block;}
			.center{text-align: center;}
			.left{text-align: left;}
			.right{text-align: right}
			.observatii .titlu{font-size: 15px; font-weight: bold;}

			.companie{float: left; width: 32%}
			.data{float: left; width: 32%; margin: 1cm 10px 0 10px }
			.client{float: left; width: 32%; text-align: left;}
			
			.titlu{text-align: center; font-size: 22px; font-weight: bold; }
			.serie_numar_data{text-align: center; }
			.serie_numar_data strong{font-size: 18px;}
			.nr_crt{width: 0.6cm}
			.cod{width: 2.7cm}
			.um{width: 1cm}
			.cant{width: 1.2cm}
			.pret{width: 1.7cm}
			.semnatura{width: 3.6cm}
			.semnatura_primire{width: 1.7cm}
			.total{width: 3.1cm; height: 2cm}
			.total span{display: inline-block; width: 100%}
			.pret_total{width: 2.1cm}
			.total_cu_tva{vertical-align: middle}
			.clauze{font-size: 10px;}
			.vm{vertical-align: middle;}
			/*.top{position: fixed; top 1cm}*/
		</style>
	</head>
	<body>
		<? $total = 0 ?>
		<? $total_tva = 0 ?>
		<table class="continut">
			<thead>
				<tr>
					<td colspan="8">
						<table style="width: 100%">
							<tr>
								<td class="right" colspan="3">
									<strong>Series: <?= $factura['serie'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number: <?= $factura['numar'] ?></strong>
								</td>
							</tr>
							<tr>
								<td class="companie">
									<strong>Supplier:</strong> <?= $factura['companie_nume'] ?><br/>
									<strong>RC:</strong> <?= $factura['companie_reg_com'] ?><br/>
									<strong>VAT no.:</strong> <?= $factura['companie_cod_fiscal'] ?><br/>
									<strong>Address:</strong> <?= nl2br($factura['companie_adresa']) ?><br/>
									<strong>Account Information:</strong><br />
									<strong>Banca Transilvania SA ORADEA</strong><br/> RO36BTRLEURCRT0300410601 <br />SWIFT: BTRLRO22<br />
									<strong>Cota TVA: <?= $factura['valoare_tva'] ?>%</strong>
								</td>
								<td class="data">
									<span class="titlu">INVOICE</span><br />
									<br />
									<strong>Invoice number:</strong> <?= $factura['numar'] ?><br />
									<strong>Date (month/day/year):</strong> <?= date('m/d/Y', strtotime($factura['data'])) ?><br />
									<strong>Due date:</strong> <?= date('m/d/Y', strtotime($factura['data_scadenta'])) ?><br />
									<? if($factura['comanda_id']!=0): ?>
									<strong>Order number:</strong> <?= $factura['comanda_id'] ?><br />
									<? if(count($comanda)): ?>
										<strong>Order date:</strong> <?= date('d/m/Y', strtotime($comanda['data'])) ?><br />
									<? endif ?>
									<? endif ?>
									
								</td>
								<td class="client">
									
									<strong>Client:</strong> <?= $factura['tert_denumire'] ?><br />
									<strong>Phone:</strong> <?= $tert['telefon'] ?><br />
									<strong>Punct livrare:</strong> 
										<? if(count($adresa_livrare)): ?>
											<?= $tara[$adresa_livrare['tara']] ?>, 
											<? if($factura['tert_tara'] == 'RO'): ?>
												<? if($adresa_livrare['judet']!=''): ?><?= $judete[$adresa_livrare['judet']] ?>,<? endif ?>
											<? else: ?>
												<?= $adresa_livrare['judet'] ?>, 
											<? endif ?>
											<? if($adresa_livrare['oras']!=''): ?><?= $adresa_livrare['oras'] ?>, <? endif ?>
											<?= trim($adresa_livrare['adresa']) ?>
										<? endif ?> 
									<br />
									<strong>RC:</strong> <?= $factura['tert_reg_com'] ?><br/>
									<strong>VAT no.:</strong> <?= $factura['tert_cod_fiscal'] ?><br />


									<strong>Address:</strong> 
										<?= $factura['tert_adresa']?><? if($factura['tert_oras']!=''): ?>, <?= $factura['tert_oras'] ?><? endif ?>, 
										<? if ($factura['tert_tara']=='RO'): ?>
											<?= $judete[$factura['tert_judet']]?>
										<? else: ?>
											<?= $factura['tert_judet'] ?>
										<? endif ?>,
										<?= $tara[$factura['tert_tara']] ?>
									<br />
									
									<strong>Account Information:</strong> <?= $factura['tert_cont_banca'] ?><br />
									<?= $factura['tert_banca'] ?><br />
									<? if($factura['modplata_id']!=0): ?>
										<strong>Payment method:</strong> <?= $modalitati_plata[$factura['modplata_id']] ?><br />
									<? endif ?>
									<strong>Explanations:</strong> <?= nl2br($factura['nota']) ?>

								</td>
							</tr>
						</table>
					</td>
				</tr>
			</thead>
			<tr class="border">
				<th class="nr_crt">No.</th>
				<th class="cod">Code</th>
				<th>Products / Services</th>
				<th class="um">UM</th>
				<th class="cant">Quantity</th>
				<th class="pret">Unit Price<br /><?= $factura['moneda'] ?></th>
				<th class="pret">Amount<br /><?= $factura['moneda'] ?></th>
				<th class="pret">VAT<br /><?= $factura['moneda'] ?></th>
			</tr>
			<tr class="border">
				<td class="center">0</td>
				<td class="center">1</td>
				<td class="center">2</td>
				<td class="center">3</td>
				<td class="center">4</td>
				<td class="center">5</td>
				<td class="center">6</td>
				<td class="center">7</td>
			</tr>
			<? foreach($factura_continut as $k=>$cc): ?>
				<? $total += round($cc['valoare'],2) ?>
				<? $total_tva += round($cc['total'],2) - round($cc['valoare'],2) ?>
				<tr class="border">
					<td class="right"><?= $k+1 ?>.</td>
					<td><?= $cc['cod'] ?></td>
					<td><?= $cc['articol'] ?></td>
					<td class="center"><?= strtoupper($cc['um']) ?></td>
					<td class="right"><?= number_format($cc['cantitate'],2) ?></td>
					<td class="right"><?= number_format(round($cc['pret_vanzare'],2),2) ?></td>
					<td class="right"><?= number_format(round($cc['valoare'],2),2) ?></td>
					<td class="right"><?= number_format(round($cc['total'],2)-round($cc['valoare'],2),2) ?></td>
				</tr>
			<? endforeach ?>
			<tr>
				<td colspan="8">
					…certificam calitatea produselor ca fiind conforme cu declaratia producatorului mentionata alaturat.<br />
					Corespunde din punct de vedere O.G. 21/1992 privind calitatea produselor…<br />
					PRODUSELE BENEFICIAZA DE GARANTIE DOAR DACA SUNT INSOTITE DE CERTIFICATUL DE GARANTIE COMPLETAT CORESPUNZATOR!!
				</td>
			</tr>
			<tfoot>
				<tr>
					<td colspan="8">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="8">
						<table class="subsol">
							<tr>
								<td rowspan="2" class="semnatura">
									Sign,<br />
									<?= $utilizator['last_name'] ?> <?= $utilizator['first_name'] ?><br />
									C.I.: <?= $utilizator['serie_ci'] ?> - <?= $utilizator['numar_ci'] ?><br />
									C.N.P.: <?= $utilizator['cnp'] ?>
									<small>Conform Art. 155(28) Legea 571/2003 - Cod fiscal, semnarea si stampilarea facturilor nu constituie elemente obligatorii pe care trebuie sa le contina factura.</small>
								</td>
								<td rowspan="2">
									Date privind expeditia<br />
									Numele delegatului: <strong><?= $factura['tert_delegat'] ?></strong> <br />
									<br />
									B.I.\C.I. Seria <strong><?= strtoupper($factura['tert_serie_ci']) ?></strong> Nr: <strong><?= $factura['tert_numar_ci'] ?></strong> eliberat(a) <?= $factura['tert_politie_ci'] ?><br />
									
									Mijloc de transport Auto <strong><?= strtoupper($factura['tert_masina']) ?></strong><br />
									Expedierea s-a efectuat in prezenta noastra la <br />
									data de &nbsp;&nbsp;&nbsp;&nbsp;<?= date('d/m/Y', strtotime($factura['data'])) ?>&nbsp;&nbsp;&nbsp;&nbsp; Ora &nbsp;&nbsp;&nbsp;&nbsp;<?= date('H:i:s', strtotime($factura['data'])) ?><br />
									&nbsp;&nbsp;&nbsp;&nbsp;Semnaturile
								</td>
								<td rowspan="2" class="semnatura_primire">Semnatura de primire</td>
								<td class="total">
									Total without VAT: <br>
									<span class="right">
										<strong><?= number_format($total, 2) ?></strong>
									</span>
								</td>
								<td class="total">
									VAT: <br />
									<span class="right">
										<strong><?= number_format($total_tva, 2) ?></strong>
									</span>
								</td>
							</tr>
							<tr>
								<td class="vm">Total <br /><strong style="font-size: 14px">(<?= $factura['moneda'] ?>)</strong></td>
								<td class="right vm"><strong><?= number_format($total+$total_tva, 2) ?></strong></td>
							</tr>
						</table>
					</td>
				</tr>
			</tfoot>
		</table>
	</body>
</html>

