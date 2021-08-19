<html>
<body>
<?php
	include("./PlatiOnlineRo/clspo.php");
	include("./PlatiOnlineRo/RSALib.php");
	$my_class = new PO3();

	$my_class->LoginID = $lid;
	$my_class->KeyEnc = $ke;
	$my_class->KeyMod = $km;

	

	$my_class->amount = number_format($comanda['total'], 2, ".", "");
	$my_class->currency = "RON";
	$my_class->OrderNumber = $comanda['id'];
	$my_class->action = "2";
	$ret = $my_class->InsertHash_Auth();


	$vOrderString= "<start_string>";
	// $total_produse = 0;
	// $total_tva = 0;
	$transport = array();
	foreach ($continut as $c) {
		if($c['cod'] != '704'){
			$vOrderString.= "<item>";
			$vOrderString.= "<ProdID>".$c['articol_id']."</ProdID>";
			$vOrderString.= "<qty>".$c['cantitate']."</qty>";
			$vOrderString.= "<itemprice>".number_format($c['pret_vanzare'], 2, ".", "")."</itemprice>";
			$vOrderString.= "<name>".$c['articol']."</name>";
			$vOrderString.= "<period></period><rec_id>0</rec_id>";
			$vOrderString.= "<description>".$c['articol']."</description>";
			$vOrderString.= "<pimg></pimg><rec_price>0</rec_price>";
			$vOrderString.= "<vat>".number_format(($c['total']-$c['valoare']), 2, ".", "")."</vat>";
			$vOrderString.= "<lang_id>ro</lang_id><stamp>".htmlspecialchars(date("F j, Y, g:i a")). "</stamp><on_stoc>1</on_stoc>";
			$vOrderString.= "<prodtype_id>1</prodtype_id><categ_id>0</categ_id><merchLoginID>0</merchLoginID>";
			$vOrderString.= "</item>";
		} else {
			$transport = $c;
		}
		// $total_produse += $c['cantitate']*$c['pret_vanzare']; 
		// $total_tva += $c['total']-$c['valoare']; 
	}

	//cupon
	//$vOrderString .= "<coupon><key>cod</key><value>".abs(round(0.05,2))."</value><percent>1</percent><workingname>Nume cupon</workingname><type>0</type><scop>0</scop><vat>0</vat></coupon>";

	//shipping
	if(count($transport))
		$vOrderString .= "<shipping><type>".$transport['articol']."</type><price>".number_format($transport['pret_vanzare'], 2, ".", "")."</price><pimg></pimg><vat>".number_format($transport['total'] - $transport['pret_vanzare'], 2, ".", "")."</vat></shipping>";
	$vOrderString .= "</start_string>";
	
?>
<form id="registerForm" autocomplete="off" method="post" action="https://secure2.plationline.ro/">
	
	<?php echo $ret; echo "\n"?>
	<input type="hidden" name="f_login" value="<?php echo $my_class->LoginID;?>">
	<input type="hidden" name="f_show_form" value="1">
	<input type="hidden" name="f_amount" value="<?php echo $my_class->amount;?>">
	<input type="hidden" name="f_currency" value="<?php echo $my_class->currency;?>">
	<input type="hidden" name="f_order_number" value="<?php echo $my_class->OrderNumber;?>">
	<input type="hidden" name="F_Language" value="ro" >
	<input type="hidden" name="F_Lang" value="ro">
	<input type="hidden" name="f_order_string" value="<?php echo $vOrderString ?>">

	<input type="hidden" name="f_first_name" id="f_first_name" value="<?= $date['prenume'] ?>">
	<input type="hidden" name="f_last_name" id="f_last_name" value="<?= $date['nume'] ?>">
	<input type="hidden" name="f_cnp" value="-">
	<input type="hidden" name="f_address" id="f_address" value="<?= $date['adresa'] ?>">
	<input type="hidden" name="f_city" id="f_city" value="<?= $date['oras'] ?>">
	<input type="hidden" name="f_state" id="f_state" value="<?= $date['judet'] ?>">
	<input type="hidden" name="f_zip" id="f_zip" value="<?= $date['cod_postal'] ?>">
	<input type="hidden" name="f_country" id="f_country" value="RO">
	<input type="hidden" name="f_phone" id="f_phone" value="<?= $date['telefon'] ?>">
	<input type="hidden" name="f_email" id="f_email" value="<?= $date['email'] ?>">
	<input type="hidden" name="f_company" value="<?= $date['denumire']!=''?$date['denumire']:'-' ?>">
	<input type="hidden" name="f_reg_com" value="<?= $date['reg_com']!=''?$date['reg_com']:'-' ?>">
	<input type="hidden" name="f_cui" value="<?= $date['cod_fiscal']!=''?$date['cod_fiscal']:'-' ?>">

	<input type="hidden" name="f_ship_to_first_name" value="<?= $date['prenume'] ?>" />
	<input type="hidden" name="f_ship_to_last_name" value="<?= $date['nume'] ?>" />
	<input type="hidden" name="f_ship_to_phone" value="<?= $date['telefon'] ?>" />

	<input type="hidden" name="f_ship_to_address" value="<?= $comanda['adresa_livrare']['adresa']!=''?$comanda['adresa_livrare']['adresa']:'-' ?>" />
	<input type="hidden" name="f_ship_to_city" value="<?= $comanda['adresa_livrare']['oras']!=''?$comanda['adresa_livrare']['oras']:'-' ?>" />
	<input type="hidden" name="f_ship_to_state" value="<?= $comanda['adresa_livrare']['judet']!=''?$comanda['adresa_livrare']['judet']:'-' ?>" />
	<input type="hidden" name="f_ship_to_zipcode" value="<?= $comanda['adresa_livrare']['cod_postal']!=''?$comanda['adresa_livrare']['adresa']:'-' ?>" />
	<input type="hidden" name="f_ship_to_country" value="RO" />

<!-- daca e test mode START here -->
	<input type="hidden" name="f_Test_Request" value="1">
<!-- daca e test mode END here -->
	<!-- <input type="submit" value="Plateste" /> -->
	<script type="text/javascript">document.getElementById('registerForm').submit();</script>
</form>
</body>
</html>