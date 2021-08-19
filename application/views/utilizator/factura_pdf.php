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
									<strong>Seria: <?= $factura['serie'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nr.: <?= $factura['numar'] ?></strong>
								</td>
							</tr>
							<tr>
								<td class="companie">
									<strong>Furnizor:</strong> <?= $factura['companie_nume'] ?><br/>
									<strong>Nr.Ord.Reg.Com/an:</strong> <?= $factura['companie_reg_com'] ?><br/>
									<strong>C.U.I.:</strong> <?= $factura['companie_cod_fiscal'] ?><br/>
									<strong>Adresa:</strong> <?= nl2br($factura['companie_adresa']) ?><br/>
									<strong>Conturi:</strong><br/>
									<strong><?= $factura['companie_banca'] ?></strong><br /><?= $factura['companie_cont'] ?><br />
									<? /* <strong>BANCA TRANSILVANIA</strong><br/> RO86 BTRL RONC RT03 0041 0601 <br /> */ ?>
									<strong>Cota TVA: <?= $factura['valoare_tva'] ?>%</strong>
								</td>
								<td class="data">
									<span class="titlu">FACTURA</span><br />
									<br />
									<strong>Nr. facturii:</strong> <?= $factura['numar'] ?><br />
									<strong>Data (zi/luna/an):</strong> <?= date('d/m/Y', strtotime($factura['data'])) ?><br />
									<strong>Scadenta:</strong> <?= date('d/m/Y', strtotime($factura['data_scadenta'])) ?><br />
									<? if($factura['comanda_id']!=0): ?>
									<strong>Nr. comanda:</strong> <?= $factura['comanda_id'] ?><br />
									<? if(count($comanda)): ?>
										<strong>Data comanda:</strong> <?= date('d/m/Y', strtotime($comanda['data'])) ?><br />
									<? endif ?>
									<? endif ?>
									
								</td>
								<td class="client">
									
									<strong>Cumparator:</strong> <?= $factura['tert_denumire'] ?><br />
									<strong>Nr. Telefon:</strong> <?= $tert['telefon'] ?><br />
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
									<strong>Nr.Ord.Reg.Com/an:</strong> <?= $factura['tert_reg_com'] ?><br/>
									<strong>C.I.F.:</strong> <?= $factura['tert_cod_fiscal'] ?><br />


									<strong>Sediul:</strong> 
										<?= $factura['tert_adresa']?><? if($factura['tert_oras']!=''): ?>, <?= $factura['tert_oras'] ?><? endif ?>, <?= $tara[$factura['tert_tara']] ?>
									<br />
									<strong>Judetul:</strong> 
									<? if ($factura['tert_tara']=='RO'): ?>
										<?= $judete[$factura['tert_judet']]?>
									<? else: ?>
										<?= $factura['tert_judet'] ?>
									<? endif ?>
									<br />
									
									<strong>Cont:</strong> <?= $factura['tert_cont_banca'] ?><br />
									<strong>Banca:</strong> <?= $factura['tert_banca'] ?><br />
									<strong>Modalitate plata:</strong> 
									<? if(array_key_exists($factura['modplata_id'], $modalitati_plata)): ?>
										<?= $modalitati_plata[$factura['modplata_id']]?>
									<? endif ?>
									<br />
									<strong>Explicatii:</strong> <?= nl2br($factura['nota']) ?>

								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="8" class="center">NR. pozitii: <?= count($factura_continut) ?></td>
				</tr>
			</thead>
			<tr class="border">
				<th class="nr_crt">Nr.crt</th>
				<th class="cod">Cod</th>
				<th>Denumirea produselor /serviciilor</th>
				<th class="um">UM</th>
				<th class="cant">Cantit.</th>
				<th class="pret">Pret Unitar<br /><?= $factura['moneda'] ?></th>
				<th class="pret">Valoare<br /><?= $factura['moneda'] ?></th>
				<th class="pret">TVA<br /><?= $factura['moneda'] ?></th>
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
					<td>
						<?= $cc['articol'] ?>
						<? if($cc['optiuni']!=''): ?>
						<br />
						<?= $cc['optiuni'] ?>
						<? endif ?>
						<? if($cc['ecotaxa']>0): ?>
						<br />
						<small>Taxa Eco este inclusa in pret in suma de <?= round($cc['ecotaxa'],2) ?> / <?= strtoupper($cc['um']) ?></small>
						<? endif ?>
					</td>
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
					Corespunde din punct de vedere O.G. 21/1992 privind calitatea produselor…NU APLICA TVA LA INCASARE<br />
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
									Semnatura si stampila furnizorului<br />
									Intocmit: <br />
									C.I.: <br />
									C.N.P.: 
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
									Total fara TVA: <br>
									<span class="right">
										<strong><?= number_format($total, 2) ?></strong>
									</span>
								</td>
								<td class="total">
									TVA: <br />
									<span class="right">
										<strong><?= number_format($total_tva, 2) ?></strong>
									</span>
								</td>
							</tr>
							<tr>
								<td class="vm">Total de plata <br /><strong style="font-size: 14px">(<?= $factura['moneda'] ?>)</strong></td>
								<td class="right vm"><strong><?= number_format($total+$total_tva, 2) ?></strong></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="8">
						Clauzele privind vanzarea: cumparatorul certifica sub semnatura ca la data prezentei bunurile cumparate au fost receptionate in stare bune si fara vicii aparante. Bunurile nu pot face obiectul revocarii ulterioare. Viciile ascunse se vor comunica in termen de 48 ore de la sesizarea lor. Plata se va face la termenul inscris pe factura. Pentru fiecare zi de intraziere cumparatorul va plati penalizari de 0.5% din suma datorata. Va multumim!
					</td>
				</tr>
			</tfoot>
		</table>
	</body>
</html>

