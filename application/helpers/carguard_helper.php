<?
function check_logged(){
	$ci =& get_instance();
	if(!$ci->session->userdata('loggedFrontend')){
		redirect(site_url());
		exit();
	}
}
function categorii_top(){
	$ci =& get_instance();
	$cat_id = categorie_parinte();
	$categorii = $ci->magazin_db->categorii(array('id_parinte' => $cat_id, 'afisata' => 1, 'afisare_globiz' => 1), array('ordine' => 'asc'));
	return $categorii;
}
function categorii_top_new($parinte_id = 0, $nivel = 0, $nivel_max = 4){
	if($nivel<$nivel_max){
		$ci =& get_instance();
		$parinte_id = ($parinte_id==0)?categorie_parinte():$parinte_id;
		$categorii = $ci->magazin_db->categorii(array('id_parinte' => $parinte_id, 'afisata' => 1, 'afisare_globiz' => 1), array('ordine' => 'asc'));
		foreach($categorii as &$categorie){
			$categorie['subcategorii'] = categorii_top_new($categorie['id'], $nivel+1, $nivel_max);
		}
		return $categorii;
	}

}

function categorie_parinte(){
	$ci =& get_instance();
	if(!$ci->session->userdata('categorieParinte'))
	{
		$cat = $ci->magazin_db->categorie(array('nume' => 'Globiz - Maniac', 'id_parinte' => 0, 'afisata' => 1, 'afisare_globiz' => 1));
		$ci->session->set_userdata('categorieParinte', $cat['id']);
	}
	return $ci->session->userdata('categorieParinte');
}
function categorii_meniu($id_parinte = 0)
{
	$ci =& get_instance();
	$categorii = $ci->magazin_db->categorii(array('id_parinte' => $id_parinte));
	foreach ($categorii as $key => $c) {
		$categorii[$key]['subcat'] = categorii_meniu($c['id'], $where);
	}
	return $categorii;
}
function meniu_stanga($id_parinte = 0, $nivel = 0, $show_image = true, $id_sub_meniu = 0, $parinte_id = 0, $id_meniu = 0)
{
	$ci =& get_instance();
	$meniu = '';
	$categorii = $ci->magazin_db->categorii(array('id_parinte' => $id_parinte, 'afisata' => 1, 'afisare_globiz' => 1), array('ordine' => 'asc'));
	if(is_array($categorii) and count($categorii))
	{
		if ($nivel == 0)
		{
			$meniu = '<ul>';
		}
		elseif ($nivel == 1)
		{
			if($id_parinte == $id_sub_meniu) {
				$meniu = '<ul class="children active">';
			} else {
				$meniu = '<ul class="children">';
			}
		}
		else
		{
			if(($parinte_id == $id_parinte) or($id_parinte == $id_meniu)){
				$meniu = '<ul class="children2 active">';
			} else {
				$meniu = '<ul class="children2">';
			}
		}

		foreach ($categorii as $key => $c) {
			$class = '';
			$no_subcat = $ci->magazin_db->no_categorii(array('id_parinte' => $c['id']));
			if($c['id'] == $id_meniu){
				$class = ' class="meniu-select"';
			}
			if(($id_sub_meniu==893) and ($c['id']!=893)){
				$_arr = explode("-", $c['path']);
				if(in_array(893, $_arr)){
					$meniu .= '<li>';
					if($no_subcat>0)
					{
						if ($nivel == 0){
							if($c['id'] == $id_sub_meniu){
								$meniu .= '<span class="arrow"><i class="fa fa-angle-up"></i></span>';
							} else {
								$meniu .= '<span class="arrow"><i class="fa fa-angle-down"></i></span>';
							}
						} else {
							$meniu .= '<span class="arrow2"><i class="fa fa-plus"></i></span>';
						}
					}

					if (isset($c['imagine']) && ! empty($c['imagine']))
					{
						$src = $ci->config->item('media_url');
						$src.='categorii/'.$c['imagine'];
						if($show_image){
							$img = '<img src="' . $ci->config->item('timthumb_url').'?src='.$src.'&w=25&h=25&zc=2" style="margin-right: 10px;">';
						} else {
							$img = '';
						}
					}
					else
					{
						$img = '';
					}
					$nume = $c['nume'.$ci->session->userdata('fieldLang')]==''?$c['nume']:$c['nume'.$ci->session->userdata('fieldLang')];
					$meniu.="<a href='".categorie_url($c)."'".$class.">".$img.$nume."</a>";
					$meniu.= meniu_stanga($c['id'], $nivel+1, false, $id_sub_meniu, $parinte_id, $id_meniu);			
					$meniu.='</li>';
				}
			} else {
				$meniu .= '<li>';
				if($no_subcat>0)
				{
					if ($nivel == 0){
						if($c['id'] == $id_sub_meniu){
							$meniu .= '<span class="arrow"><i class="fa fa-angle-up"></i></span>';
						} else {
							$meniu .= '<span class="arrow"><i class="fa fa-angle-down"></i></span>';
						}
					} else {
						if(($c['id'] == $parinte_id) or ($c['id'] == $id_meniu)){
							$meniu .= '<span class="arrow2"><i class="fa fa-minus"></i></span>';
						} else {
							$meniu .= '<span class="arrow2"><i class="fa fa-plus"></i></span>';
						}
					}
				}

				if (isset($c['imagine']) && ! empty($c['imagine']))
				{
					$src = $ci->config->item('media_url');
					$src.='categorii/'.$c['imagine'];
					if($show_image){
						$img = '<img src="' . $ci->config->item('timthumb_url').'?src='.$src.'&w=25&h=25&zc=2" style="margin-right: 10px;">';
					} else {
						$img = '';
					}
				}
				else
				{
					$img = '';
				}
				$img = '';
				$nume = $c['nume'.$ci->session->userdata('fieldLang')]==''?$c['nume']:$c['nume'.$ci->session->userdata('fieldLang')];
				$meniu.="<a href='".categorie_url($c)."'".$class.">".$img.$nume."</a>";
				$meniu.= meniu_stanga($c['id'], $nivel+1, false, $id_sub_meniu, $parinte_id, $id_meniu);
				$meniu.='</li>';
			}
		}
		$meniu.= "</ul>";
	}
	return $meniu;
}
function meniu_stanga_old($id_parinte = 0)
{
	$ci =& get_instance();
	$meniu = '';
	$categorii = $ci->magazin_db->categorii(array('id_parinte' => $id_parinte), array('ordine' => 'asc'));
	if(is_array($categorii) and count($categorii))
	{
		$meniu = '<ul id="nice-menu-1" class="nice-menu nice-menu-right nice-menu-menu-categorii nice-menus-processed sf-js-enabled">';
		foreach ($categorii as $key => $c) {
			$class = '';
			$no_subcat = $ci->magazin_db->no_categorii(array('id_parinte' => $c['id']));
			if($no_subcat>0)
				$class = 'menuparent';
			$meniu.="<li class='".$class."'><a href='".categorie_url($c)."'>".$c['nume']."</a>";
			$meniu.= meniu_stanga($c['id']);
			$meniu.="</li>";
		}
		$meniu.= "</ul>";
	}
	return $meniu;
}
function categorie_url($categorie)
{
	return site_url('categorie/'.$categorie['id']);
}
function produs_url($produs){
	return site_url('produs/'.$produs['id']);
}
function categorie_tree($id, $lastId){
	$ci =& get_instance();
	$categorie = $ci->magazin_db->categorie(array('id' => $id));
	$array = array();
	
	if(is_array($categorie) and count($categorie))
	{
		//$nume.= categorie_tree($categorie['id_parinte']).' :: '.$categorie['nume'];
		//$nume = categorie_tree($categorie['id_parinte']);
		if($categorie['id']!=categorie_parinte())
		{
			$nume = $categorie['nume'.$ci->session->userdata('fieldLang')]==''?$categorie['nume']:$categorie['nume'.$ci->session->userdata('fieldLang')];
			if($categorie['id'] == $lastId)
			{
				//$array[] = $categorie['nume'];
				$array[] = "<a href='".categorie_url($categorie)."'>".$nume."</a>";
			}
			else
			{
				$array[] = "<a href='".categorie_url($categorie)."'>".$nume."</a> <i class='fas fa-angle-double-right orange'></i></i>";
			}
			$array = array_merge(categorie_tree($categorie['id_parinte'], $lastId), $array);
		}
	}
	return $array;
}
function produsInGrup($id){
	$ci =& get_instance();
	$art = $ci->magazin_db->articol_grup(array('articol_id' => $id));
	if(is_array($art) and count($art))
		return $art['grup_id'];
		else return 0;
}
function reduceriProdus($id){
	$ci =& get_instance();
	$reduceri = $ci->magazin_db->plafoane_reducere_individuale(array('articol_id' => $id));
	return $reduceri;
}

function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}

function lang_new($line, $for = '', $attributes = array())
{
	$line_new = get_instance()->lang->line($line);
	if($line_new==''){
		$line_new = $line;
	}
	$line = $line_new;
	if ($for !== '')
	{
		$line = '<label for="'.$for.'"'._stringify_attributes($attributes).'>'.$line.'</label>';
	}
	
	return $line;
}

function clean_str($str) {
	$str = convert_accented_characters($str);
	$str = strip_tags($str);
	$str = str_replace(array('|', "<br>"), array('-', " "), $str);
	$str = str_replace("\r\n", " ", $str);
	$str = str_replace("\r", " ", $str);
	$str = str_replace("\n", " ", $str);
	$str = character_limiter($str,190,'');
	$str = trim($str);
	return $str;
}


function clean_title($str) {
	$str = convert_accented_characters($str);
	$str = strip_tags($str);
	$str = str_replace(array('|', "<br>"), array('-', " "), $str);
	$str = str_replace("\r\n", " ", $str);
	$str = str_replace("\r", " ", $str);
	$str = str_replace("\n", " ", $str);
	$str = character_limiter($str,100,'');
	$str = trim(strtolower($str));
	return $str;
}

function clean_descr($str) {
	$str = convert_accented_characters($str);
	$str = strip_tags($str);
	$str = str_replace(array('|', "<br>"), array('-', " "), $str);
	$str = str_replace("\r\n", " ", $str);
	$str = str_replace("\r", " ", $str);
	$str = str_replace("\n", " ", $str);
	$str = character_limiter($str,5000,'');
	$str = trim(strtolower($str));
	return $str;
}


function lang($line, $id = '')
{
	$CI =& get_instance();
	if($CI->lang->line($line)!='')
		$line = $CI->lang->line($line);
		

	if ($id != '')
	{
		$line = '<label for="'.$id.'">'.$line."</label>";
	}

	return $line;
}
function pret_mic($produs, $curs=1){
	$discount = 0;

	$ci =& get_instance();
	$ci->load->model('magazin_db');
	if($produs['pret_intreg'] > $produs['pret_vanzare']){
		//produs cu reducere
		$pret_mic = $produs['pret_vanzare'];
	} else {
		$grup_articol = $ci->magazin_db->articol_grup(array('articol_id' => $produs['id']));
		if(is_array($grup_articol) and count($grup_articol)){
			//produsul face parte dintr-un grup
			$plafon = $ci->magazin_db->discount_grup(array('grup_id' => $grup_articol['grup_id']));
			$discount = $plafon['discount'];
		} else {
			$plafon_articol = $ci->magazin_db->plafoan_reducere_individual(array('articol_id' => $produs['id']));
			if(is_array($plafon_articol) and count($plafon_articol)){
				//produsul are plafoane individuale
				$discount = $plafon_articol['discount'];
			} else {
				//discount general site
				$plafon_reducere = $ci->magazin_db->plafoan_reducere_general();
				$discount = $plafon_reducere['discount'];
			}
		}
		$pret_mic = $produs['pret_vanzare'] - ($produs['pret_vanzare']*$discount/100);
	}
	
	return $pret_mic;
}

function pret_mic_materom($tert, $produs, $curs=1){
	$discount = 0;

	$ci =& get_instance();
	$ci->load->model('magazin_db');
	if($produs['pret_intreg'] > $produs['pret_vanzare']){
		//produs cu reducere
		$pret_mic = $produs['pret_vanzare'];
	} else {
		$grup_articol = $ci->magazin_db->articol_grup(array('articol_id' => $produs['id']));
		if(is_array($grup_articol) and count($grup_articol)){
			//produsul face parte dintr-un grup
			$plafon = $ci->magazin_db->discount_grup(array('grup_id' => $grup_articol['grup_id']));
			$discount = $plafon['discount'];
		} else {
			$plafon_articol = $ci->magazin_db->plafoan_reducere_individual(array('articol_id' => $produs['id']));
			if(is_array($plafon_articol) and count($plafon_articol)){
				//produsul are plafoane individuale
				$discount = $plafon_articol['discount'];
			} else {
				//discount general site
				$plafon_reducere = $ci->magazin_db->plafoan_reducere_general();
				$discount = $plafon_reducere['discount'];
			}
		}
		$pret_mic = $produs['pret_vanzare'] - ($produs['pret_vanzare']*$discount/100);
	}
	// print_R($tert);
	$pret_mic = $pret_mic*((100-(int)$tert['discount'])/100);
	return $pret_mic;
}
function categorii_meniu_submeniu(){
	$ci =& get_instance();
	$ci->load->model('magazin_db');
	$categorii = $ci->magazin_db->categorii(array('id_parinte' => $ci->config->item('shop_id'), 'afisata' => 1, 'afisare_globiz' => 1), array('ordine' => 'asc'));
	foreach($categorii as &$categorie){
		$categorie['submeniu'] = $ci->magazin_db->categorii(array('id_parinte' => $categorie['id'], 'afisata' => 1, 'afisare_globiz' => 1), array('ordine' => 'asc'));
	}
	return $categorii;
}

function cui($text){
	//echo $text.'<br>';
	$text = preg_replace("/(^0\.)(.*)/",'$2',$text); // scot punct de la inceputul stringului
	//echo '0: '.$text.'<br>';
	$text = preg_replace('/[^A-Za-z0-9]/', '', $text);
	$text = strtoupper($text);
	// $text = str_replace(" ", "", $text);
	// $text = str_replace(".", "", $text);
	// $text = str_replace(",", "", $text);
	//^(ATU[0-9]{8}|BE[01][0-9]{9}|BG[0-9]{9,10}|HR[0-9]{11}|CY[A-Z0-9]{9}|CZ[0-9]{8,10}|DK[0-9]{8}|EE[0-9]{9}|FI[0-9]{8}|FR[0-9A-Z]{2}[0-9]{9}|DE[0-9]{9}|EL[0-9]{9}|HU[0-9]{8}|IE([0-9]{7}[A-Z]{1,2}|[0-9][A-Z][0-9]{5}[A-Z])|IT[0-9]{11}|LV[0-9]{11}|LT([0-9]{9}|[0-9]{12})|LU[0-9]{8}|MT[0-9]{8}|NL[0-9]{9}B[0-9]{2}|PL[0-9]{10}|PT[0-9]{9}|RO[0-9]{2,10}|SK[0-9]{10}|SI[0-9]{8}|ES[A-Z]([0-9]{8}|[0-9]{7}[A-Z])|SE[0-9]{12}|GB([0-9]{9}|[0-9]{12}|GD[0-4][0-9]{2}|HA[5-9][0-9]{2}))$
	$text = preg_replace("/(R|RO)(\d+)(.*)/",'$2',$text);
	
	//echo '1: '.$text.'<br>';
	$text = preg_replace("/(\.)(.*)/",'$2',$text); // scot punct de la inceputul stringului
	//echo '3: '.$text.'<br>';
	$text = trim($text);
	//echo '<hr>';
	return $text;
}

function pret_produs($produs, $plafoane_reducere, $pret_special = false, $tip_tert = ''){
	$ci =& get_instance();
	if($tip_tert == ''){
		 $tip_tert = $ci->session->userdata('tip_pret');
	}
	// echo 'Tip tert: '.$tip_tert;
	$pret = array();
	if($pret_special == true){
		if($ci->session->userdata('loggedFrontend')){
			$pret = $ci->magazin_db->pret_special(array('articol_id' => $produs['id'], 'tert_id' => $ci->session->userdata('tert_id')));
		}
	}
	$discountVal = 0;
	$maxDiscount = 0;
	if(is_array($pret) and count($pret)){
		$produs['pret_intreg'] = $produs['pret_vanzare'];
		$produs['pret_vanzare'] = $pret['pret'];
		$produs['pret_vanzare_tva'] = $produs['pret_vanzare']*(100+$produs['tva'])/100;
		$produs['discount'] = array();
	} else {
		if(($ci->config->item('blackfriday') and !($ci->session->userdata('dropshipping')))) {
			$tip_tert = 1;
		}
		if( in_array($produs['furnizor_id'], $ci->furnizori_asociati) or !($ci->session->userdata('discount')>0)){
			if($produs['pret_intreg']<=$produs['pret_vanzare']){
				
		////print_R($produs);
		//print_r($ci->session->userdata());
		//exit();
				switch($tip_tert){
					case 4: //pret mare
						$produs['pret_intreg'] = 0;
						$produs['pret_vanzare'] = $produs['pret_vanzare'];
						$produs['pret_vanzare_tva'] = $produs['pret_vanzare']*(100+$produs['tva'])/100;
						$produs['discount'] = array();
						
						//$art_gr = $ci->magazin_db->articol_grup(array('articol_id' => $produs['id']));
						//if(count($art_gr))
						//{
						//	$produs['discount'] =  $ci->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($produs['id'])));
						//} elseif(count($plafon = reduceriProdus($produs['id']))) {
						//	$produs['discount'] = $plafon;
						//} else{
						//	//reduceri generale
						//	$produs['discount'] = $plafoane_reducere;
						//}
						//
						//if(count($produs['discount'])>0){
						//	if(isset($produs['discount'][round(count($produs['discount'])/2-1)]['discount'])){
						//		$produs['pret_intreg'] = $produs['pret_vanzare'];
						//		$produs['pret_vanzare'] = $produs['pret_vanzare']*(100-$produs['discount'][round(count($produs['discount'])/2-1)]['discount'])/100;
						//		$produs['pret_vanzare_tva'] = $produs['pret_vanzare']*(100+$produs['tva'])/100;
						//	}
						//}
						break;
					case 3: //pret mic
						$art_gr = $ci->magazin_db->articol_grup(array('articol_id' => $produs['id']));
						if(is_array($art_gr) and count($art_gr))
						{
							$produs['discount'] =  $ci->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($produs['id'])));
						} elseif(count($plafon = reduceriProdus($produs['id']))) {
							$produs['discount'] = $plafon;
						} else{
							//reduceri generale
							$produs['discount'] = $plafoane_reducere;
						}
						if(is_array($produs['discount']) and count($produs['discount'])>0){
							if(isset($produs['discount'][count($produs['discount'])-1]['discount'])){
								$produs['pret_intreg'] = $produs['pret_vanzare'];
								$produs['pret_vanzare'] = $produs['pret_vanzare']*(100-$produs['discount'][count($produs['discount'])-1]['discount'])/100;
								$produs['pret_vanzare_tva'] = $produs['pret_vanzare']*(100+$produs['tva'])/100;
							}
						}
						break;
					case 2: //pret mediu
						$art_gr = $ci->magazin_db->articol_grup(array('articol_id' => $produs['id']));
						if(is_array($art_gr) and count($art_gr))
						{
							$produs['discount'] =  $ci->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($produs['id'])));
						} elseif(count($plafon = reduceriProdus($produs['id']))) {
							$produs['discount'] = $plafon;
						} else{
							//reduceri generale
							$produs['discount'] = $plafoane_reducere;
						}
						if(is_array($produs['discount']) and count($produs['discount'])>0){
							if(isset($produs['discount'][round(count($produs['discount'])/2-1)]['discount'])){
								$produs['pret_intreg'] = $produs['pret_vanzare'];
								$produs['pret_vanzare'] = $produs['pret_vanzare']*(100-$produs['discount'][round(count($produs['discount'])/2-1)]['discount'])/100;
								$produs['pret_vanzare_tva'] = $produs['pret_vanzare']*(100+$produs['tva'])/100;
							}
						}
						break;
					default:
						$art_gr = $ci->magazin_db->articol_grup(array('articol_id' => $produs['id']));
						if(is_array($art_gr) and count($art_gr))
						{
							//produs in grup
							if(isset($grupuri[$art_gr['grup_id']]))
							{
								$discount = $ci->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
								if(is_array($discount) and count($discount))
								{
									$discountVal = $discount['discount'];
								}
							}
							$produs['discount'] =  $ci->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($produs['id'])));
							foreach ($produs['discount'] as $d) {
								if($maxDiscount < $d['discount'])
									$maxDiscount = $d['discount'];
							}
						} elseif(count($plafon = reduceriProdus($produs['id']))) {
							$produs['discount'] = $plafon;
							$cart_item = $ci->cart->find_by_id($produs['id']);
							if(is_array($cart_item) and count($cart_item))
							{
								$discount = $ci->magazin_db->plafoan_reducere_individual(array('articol_id' => $produs['id'], 'no_produse <= '=>$cart_item['qty']/$produs['cantitate']));
								if(is_array($discount) and count($discount))
									$discountVal = $discount['discount'];
							}
							foreach ($produs['discount'] as $d) {
								if($maxDiscount < $d['discount'])
									$maxDiscount = $d['discount'];
							}
						} else{
							//reduceri generale
							$produs['discount'] = $plafoane_reducere;
							$cart_item = $ci->cart->find_by_id($produs['id']);
							if(is_array($cart_item) and count($cart_item))
							{
								$discount = $ci->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$produs['cantitate']));
								if(is_array($discount) and count($discount))
									$discountVal = $discount['discount'];
							}
							foreach ($produs['discount'] as $d) {
								if($maxDiscount < $d['discount'])
									$maxDiscount = $d['discount'];
							}
						}
						break;
				}
			}
		}
	}
	$produs['discountVal'] =  $discountVal;
	$produs['maxDiscount'] = $maxDiscount;
	
	return $produs;
}
function copiere_comanda($id){
	$ci =& get_instance();
	$ci->load->model('comenzi_db');
	
	$comanda = $ci->comenzi_db->comanda(array('id' => $id));
	$comanda_originala = $ci->comenzi_db->comanda_originala(array('id' => $id));
	if(is_array($comanda_originala) and count($comanda_originala)){
		$ci->comenzi_db->actualizeaza_originala($id, $comanda);
	} else {
		$ci->comenzi_db->adauga_originala($comanda);
	}
	$ci->comenzi_db->sterge_continut_comanda_originala(array('comanda_id' => $id));
	$continut = $ci->comenzi_db->continut(array('comanda_id' => $id));
	foreach($continut as $c){
		$ci->comenzi_db->adauga_continut_comanda_originala($c);
	}
}
function insertLog($rec)
{
	$ci = & get_instance();
	$ci->load->model('logs_db');
	$ci->logs_db->adauga($rec);
}

function discount_negociat(){
	$ci = & get_instance();
	$cos = $ci->cart->contents();
	$discount = array();
	$total_cos = 0;
	foreach ($cos as $c) {
		if(!(isset($c['options']['furnizor_id']) and in_array($c['options']['furnizor_id'], $ci->furnizori_asociati))){
			if(($c['id']!='voucher') or ($c['id']!='transport')){
				$produs = $ci->magazin_db->produs(array('id' => $c['id']));
				if(is_array($produs) and count($produs)){
					$total_cos += $c['subtotal']*(100+$produs['tva'])/100;
				}
			}
		}
	}
	if($total_cos>0){
		$item = $ci->cart->find_by_id('discount');
		if($item){	
			//actualizare
			$discount_valoare = $ci->session->userdata('discount');
			$discount_total = $total_cos*$discount_valoare/100;
			$data = array(
				'rowid' => $item['rowid'],
				'price'	=> $discount_total*100/(100+$ci->companie_tva),
				);
			$ci->cart->update_price($data);
			$discount = $ci->cart->find_by_id('discount');
			$discount['tva'] = $ci->companie_tva;
		} else {
			//adauga
			if(is_array($cos) and count($cos)){
				$discount_valoare = $ci->session->userdata('discount');
				if($discount_valoare>0){
					$discount_total = $total_cos*$discount_valoare/100;
					$data = array(
						'id'      => 'discount',
						'qty'     => -1,
						'price'   => $discount_total*100/(100+$ci->companie_tva),
						'name'    => lang('discount_negociat_la_contract'),
						'options' => array(
								'info' 	=> 'discount',
								'cod'	=> '709'
							)
						);
					$ci->cart->insert($data);
					$discount = $item = $ci->cart->find_by_id('discount');
					$discount['tva'] = $ci->companie_tva;
				}
			} else {
				$discount = array();
			}
		}
	} else {
		$item = $ci->cart->find_by_id('discount');
		if($item){
			//actualizare
			$transport = $item;
			$data = array(
				'rowid' => $item['rowid'],
				'qty'	=> 0
			);
			$ci->cart->update($data);
		}
	}
	return $discount;
}