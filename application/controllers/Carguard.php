<?
class Carguard extends MY_Controller
{
	var $layout, $content;
	function __construct()
	{
		parent::__construct();
		// $this->per_page = 5;

	}
	
	function index()
	{
		//$this->layout['nav_select'] = 'dashboard';
		//produse promo
		$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();

		$where = array('promo' => '1', 'activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
		$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
		$produse_promo = $this->magazin_db->produse($where, array(), array('per_page'=> 6, 'no'=>0), $sql);
		//print_R($produse_promo);
		foreach ($produse_promo as $k => &$p) {
			$p = pret_produs($p, $plafoane_reducere);
			////$p['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			////$produse_promo[$k]['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
			//$p['discount'] = array();
			//$maxDiscount = 0;
			//$discountVal = 0;
			//$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			//if($p['pret_intreg']<=$p['pret_vanzare']){
			//	$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
			//	if(count($art_gr))
			//	{
			//		//produsul este in grup
			//		if(isset($grupuri[$art_gr['grup_id']]))
			//		{
			//			$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
			//			if(count($discount))
			//			{
			//				$discountVal = $discount['discount'];
			//			}
			//		}
			//		$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
			//		$produse_promo[$k]['discount'] =  $discount_grup;
			//		foreach ($produse_promo[$k]['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	} elseif(count($discount_produs = reduceriProdus($p['id']))) {
			//		$produse_promo[$k]['discount'] = $discount_produs;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($produse_promo[$k]['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}else{
			//		//reduceri generale
			//		$produse_promo[$k]['discount'] = $plafoane_reducere;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($produse_promo[$k]['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}
			//}
			//$produse_promo[$k]['maxDiscount'] =  $maxDiscount;
			//$produse_promo[$k]['discountVal'] =  $discountVal;
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$produse_promo[$k]['imagine'] = $imagine;
			$produse_promo[$k]['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
		}

		$where = array('pret_bomba' => '1', 'activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
		$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
		$produse_bomba = $this->magazin_db->produse($where, array('RAND()' => 'RAND()'), array('per_page'=> 2, 'no'=>0), $sql);
		foreach ($produse_bomba as $k => &$p) {
			//$p['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			//$produse[$k]['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
			$p = pret_produs($p, $plafoane_reducere);
			//$produse_bomba[$k]['discount'] = array();
			//$maxDiscount = 0;
			//$discountVal = 0;
			//$produse_bomba[$k]['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			//$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			//if($p['pret_intreg']<=$p['pret_vanzare']){
			//	$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
			//	if(count($art_gr))
			//	{
			//		//produsul este in grup
			//		if(isset($grupuri[$art_gr['grup_id']]))
			//		{
			//			$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
			//			if(count($discount))
			//			{
			//				$discountVal = $discount['discount'];
			//			}
			//		}
			//		$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
			//		$produse_bomba[$k]['discount'] =  $discount_grup;
			//		foreach ($produse_bomba[$k]['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	} elseif(count($discount_produs = reduceriProdus($p['id']))) {
			//		$produse_bomba[$k]['discount'] = $discount_produs;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($produse_bomba[$k]['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}else{
			//		//reduceri generale
			//		$produse_bomba[$k]['discount'] = $plafoane_reducere;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($produse_bomba[$k]['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}
			//}
			//$produse_bomba[$k]['maxDiscount'] =  $maxDiscount;
			//$produse_bomba[$k]['discountVal'] =  $discountVal;
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$produse_bomba[$k]['imagine'] = $imagine;
			$produse_bomba[$k]['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
		}
		
		$where = array('nou_homepage' => '1', 'activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
		$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
		$produse_noutati = $this->magazin_db->produse($where, array('RAND()' => 'RAND()'), array('per_page'=> 2, 'no'=>0), $sql);
		foreach ($produse_noutati as $k => &$p) {
			$p = pret_produs($p, $plafoane_reducere);
			//$p['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			//$produse[$k]['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
		
			//$produse_noutati[$k]['discount'] = array();
			//$maxDiscount = 0;
			//$discountVal = 0;
			//$produse_noutati[$k]['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			//$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			//if($p['pret_intreg']<=$p['pret_vanzare']){
			//	$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
			//	if(count($art_gr))
			//	{
			//		//produsul este in grup
			//		if(isset($grupuri[$art_gr['grup_id']]))
			//		{
			//			$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
			//			if(count($discount))
			//			{
			//				$discountVal = $discount['discount'];
			//			}
			//		}
			//		$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
			//		$produse_noutati[$k]['discount'] =  $discount_grup;
			//		foreach ($produse_noutati[$k]['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	} elseif(count($discount_produs = reduceriProdus($p['id']))) {
			//		$produse_noutati[$k]['discount'] = $discount_produs;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($produse_noutati[$k]['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}else{
			//		//reduceri generale
			//		$produse_noutati[$k]['discount'] = $plafoane_reducere;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($produse_noutati[$k]['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}
			//}
			//$produse_noutati[$k]['maxDiscount'] =  $maxDiscount;
			//$produse_noutati[$k]['discountVal'] =  $discountVal;
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$produse_noutati[$k]['imagine'] = $imagine;
			$produse_noutati[$k]['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
		}
		
		$where = array('recomandate' => '1', 'activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
		$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
		$produse_recomandate = $this->magazin_db->produse($where, array(), array('per_page'=> 6, 'no'=>0), $sql);
		//print_R($produse_promo);
		foreach ($produse_recomandate as $k => &$p) {
			$p = pret_produs($p, $plafoane_reducere);
			//$p['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			//$produse_promo[$k]['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
			//$p['discount'] = array();
			//$maxDiscount = 0;
			//$discountVal = 0;
			//$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			//if($p['pret_intreg']<=$p['pret_vanzare']){
			//	$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
			//	if(count($art_gr))
			//	{
			//		//produsul este in grup
			//		if(isset($grupuri[$art_gr['grup_id']]))
			//		{
			//			$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
			//			if(count($discount))
			//			{
			//				$discountVal = $discount['discount'];
			//			}
			//		}
			//		$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
			//		$p['discount'] =  $discount_grup;
			//		foreach ($p['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	} elseif(count($discount_produs = reduceriProdus($p['id']))) {
			//		$p['discount'] = $discount_produs;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($p['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}else{
			//		//reduceri generale
			//		$p['discount'] = $plafoane_reducere;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($p['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}
			//}
			//$p['maxDiscount'] =  $maxDiscount;
			//$p['discountVal'] =  $discountVal;
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$p['imagine'] = $imagine;
			$p['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
		}
		
		$where = array('lichidari' => '1', 'activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
		$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
		$produse_lichidari = $this->magazin_db->produse($where, array(), array('per_page'=> 6, 'no'=>0), $sql);
		//print_R($produse_promo);
		foreach ($produse_lichidari as $k => &$p) {
			$p = pret_produs($p, $plafoane_reducere);
			//$p['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			//$produse_promo[$k]['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
			//$p['discount'] = array();
			//$maxDiscount = 0;
			//$discountVal = 0;
			//$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			//if($p['pret_intreg']<=$p['pret_vanzare']){
			//	$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
			//	if(count($art_gr))
			//	{
			//		//produsul este in grup
			//		if(isset($grupuri[$art_gr['grup_id']]))
			//		{
			//			$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
			//			if(count($discount))
			//			{
			//				$discountVal = $discount['discount'];
			//			}
			//		}
			//		$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
			//		$p['discount'] =  $discount_grup;
			//		foreach ($p['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	} elseif(count($discount_produs = reduceriProdus($p['id']))) {
			//		$p['discount'] = $discount_produs;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($p['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}else{
			//		//reduceri generale
			//		$p['discount'] = $plafoane_reducere;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($p['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}
			//}
			//$p['maxDiscount'] =  $maxDiscount;
			//$p['discountVal'] =  $discountVal;
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$p['imagine'] = $imagine;
			$p['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
		}
		
		$cat_id = categorie_parinte();
		$categorii = $this->magazin_db->categorii(array('id_parinte' => $cat_id), array('ordine' => 'asc'));
		$this->content['categorii'] = $categorii;
		$this->content['produse_promo'] = $produse_promo;
		$this->content['produse_recomandate'] = $produse_recomandate;
		$this->content['produse_lichidari'] = $produse_lichidari;
		$this->content['produse_bomba'] = $produse_bomba;
		$this->content['produse_noutati'] = $produse_noutati;
		
		$this->layout['javascript'][] = site_url('assets/plugins/lightslider/js/lightslider.min.js');
		$this->layout['css'][] = site_url('assets/plugins/lightslider/css/lightslider.min.css');
		
		$this->layout['show_sidebar'] = true;
		$this->layout['large'] = true;
		$this->content['is_home'] = true;
		$this->displayPage('home');
	}
	function preview()
	{
		$this->layout['javascript'][] = base_url().THEMESFOLDER.'js/easyResponsiveTabs.js';
		$this->layout['javascript'][] = base_url().THEMESFOLDER.'js/jquery.etalage.min.js';
		$this->layout['javascript'][] = base_url().THEMESFOLDER.'js/star-rating.js';
		$this->layout['javascript'][] = base_url().THEMESFOLDER.'js/preview.js';
		$this->layout['css'][] = site_url('css/easy-responsive-tabs.css');
		$this->layout['css'][] = site_url('css/etalage.css');
		$this->displayPage('magazin/preview');
	}
	function mesaj(){
		if($this->session->flashdata('message')!=''){
			$this->content['titlu'] = $this->session->flashdata('titlu');;
			$this->content['message'] = $this->session->flashdata('message');
			$this->content['mesaj'] = $this->load->view('message', $this->content, true);
			$this->layout['content'] = $this->load->view('mesaj', $this->content, true);
			$this->load->view('layout', $this->layout);
		} else {redirect(site_url());exit();}
	}
	function categorie()
	{
		$id = $this->uri->rsegment(3);
		$this->session->set_userdata('categorie_id', $id);
		$categorie = $this->magazin_db->categorie(array('id' => $id));
		if(!(is_array($categorie) and count($categorie))) {
			redirect(site_url(),'location',301); exit();
		}
		//if($categorie['id_parinte'] != $this->config->item('shop_id')){
		//	$this->categorie_afisare($id);
		//	exit();
		//}
		if($categorie['id_parinte'] != $this->config->item('shop_id')){
			$this->categorie_subcategorii($id);
		} else {
			$where_arr = array('articole_categorii.categorie_id' => $id, 'articole.activ' => 1, 'articole.afisare_globiz' => 1);
			$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';

			$filtre = $this->magazin_db->atribute_articole_categorie(array('categorie_id' => $id), array('ordine' => 'asc'));
			$sql_atribute = array();
			$atribute_selectare = $this->input->get('atribut');
			if(is_array($atribute_selectare)){
				foreach ($atribute_selectare as $atribut_id => $valori) {
					$sql_atribute[] =  "articole.id IN (SELECT articol_id FROM articole_atribute WHERE valoare_id IN (".implode(", ", $valori)."))";
					// foreach ($valori as $v){
					// 	$sql_atribute[] = $v;
					// }
				}
			}
			if(is_array($sql_atribute) and count($sql_atribute)){
				$sql_atribute =  implode(" AND ", $sql_atribute);
				$sql.=" AND ".$sql_atribute;
			}

			$produse = $this->magazin_db->produse_categorie($where_arr, array('ordine' => 'asc', 'produs_precomandabil' => 'asc', 'articole.cod' => 'asc'), array('per_page'=> $this->per_page, 'no'=>0), $sql);
			//echo $this->db->last_query();
			$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
			
			$cos = $this->cart->contents();
			$grupuri = array();
			foreach($cos as $k=>$c){
				//$produs = $this->magazin_db->produs(array('id' => $c['id']));
				$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $c['id']));
				if(is_array($art_gr) and count($art_gr))
				{
					if(isset($grupuri[$art_gr['grup_id']]['no_produse']))
						$grupuri[$art_gr['grup_id']]['no_produse'] += $c['qty'];
						else $grupuri[$art_gr['grup_id']]['no_produse'] = $c['qty'];
				}
			}
			
			foreach ($produse as $k => &$p) {
				$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
				$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
				
				$p = pret_produs($p, $plafoane_reducere);
				//$produse[$k]['discount'] = array();
				//$discountVal = 0;
				//$maxDiscount = 0;
				////$stocuri = $this->magazin_db->produs_locatii(array('articol_id' => $p['id']));
				////$stoc = 0;
				////foreach ($stocuri as $s) {
				////	$stoc+=$s['stoc'];
				////}
				////$produse[$k]['stoc'] = $stoc;
				//$produse[$k]['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
				//$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
				//if($this->session->userdata('discount')!=-1){
				//	if( in_array($p['furnizor_id'], $this->furnizori_asociati) or !($this->session->userdata('discount')>0)){
				//		if($p['pret_intreg']<=$p['pret_vanzare']){
				//			$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
				//			if(count($art_gr))
				//			{
				//				//produsul este in grup
				//				if(isset($grupuri[$art_gr['grup_id']]))
				//				{
				//					$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
				//					if(count($discount))
				//					{
				//						$discountVal = $discount['discount'];
				//					}
				//				}
				//				$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
				//				$produse[$k]['discount'] =  $discount_grup;
				//				foreach ($produse[$k]['discount'] as $d) {
				//					if($maxDiscount < $d['discount'])
				//						$maxDiscount = $d['discount'];
				//				}
				//			} elseif(count($discount_produs = reduceriProdus($p['id']))) {
				//				$produse[$k]['discount'] = $discount_produs;
				//				$cart_item = $this->cart->find_by_id($p['id']);
				//				if(count($cart_item))
				//				{
				//					$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
				//					if(count($discount))
				//						$discountVal = $discount['discount'];
				//				}
				//				foreach ($produse[$k]['discount'] as $d) {
				//					if($maxDiscount < $d['discount'])
				//						$maxDiscount = $d['discount'];
				//				}
				//			}else{
				//				//reduceri generale
				//				$produse[$k]['discount'] = $plafoane_reducere;
				//				$cart_item = $this->cart->find_by_id($p['id']);
				//				if(count($cart_item))
				//				{
				//					$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
				//					if(count($discount))
				//						$discountVal = $discount['discount'];
				//				}
				//				foreach ($produse[$k]['discount'] as $d) {
				//					if($maxDiscount < $d['discount'])
				//						$maxDiscount = $d['discount'];
				//				}
				//			}
				//		}
				//	}
				//}
				//$produse[$k]['maxDiscount'] =  $maxDiscount;
				//$produse[$k]['discountVal'] =  $discountVal;
				$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
				$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
				$p['imagine'] = $imagine;
				$p['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
				//$produse[$k]['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
			}
			//print_r($filtre);
			$this->content['categorie'] = $categorie;
			$this->content['produse'] = $produse;
			//$this->content['subcategorii'] = $this->magazin_db->categorii(array('id_parinte' => $id), array('ordine' => 'asc'));
			
			$path = explode("-",$categorie['path']);
			if(is_array($path) and count($path)>1)
				$id_meniu = $path[1];
				else $id_meniu = $categorie['id'];
			if(is_array($path) and count($path)>2)
				$id_sub_meniu = $path[2];
			elseif(is_array($path) and count($path)==2)
				$id_sub_meniu = $categorie['id'];
			else
				$id_sub_meniu = '';
			$this->content['id_meniu'] = $id_meniu;
			$this->content['id_sub_meniu'] = $id_sub_meniu;
			$this->content['id_parinte'] = $categorie['id_parinte'];
			$this->content['pagina'] = 1;
			$this->content['filtre'] = $filtre;
			$this->content['atribute_selectare'] = $atribute_selectare;
			$this->layout['current_page'] = 'produse';
			
			//$this->layout['javascript'][] = base_url().'assets/plugins/jquery.jscroll.js';
			$this->layout['javascript'][] = base_url().'assets/plugins/infinite-scroll.min.js';
			$this->layout['javascript'][] = base_url().'assets/scripts/categorie.js?v='.$this->config->item('css_js');
			$this->layout['title'] = $categorie['nume'.$this->session->userdata('fieldLang')]!=''?$categorie['nume'.$this->session->userdata('fieldLang')]:$categorie['nume'];
			$this->displayPage('magazin/categorie');
		}
	}
	function categorie_pagina(){
		$id = $this->uri->segment(3);
		$pagina = $this->uri->segment(4);
		$atribute_selectare = $this->input->get('atribut');

		$categorie = $this->magazin_db->categorie(array('id' => $id));
		$where_arr = array('articole_categorii.categorie_id' => $id, 'articole.activ' => 1, 'articole.afisare_globiz' => 1);
		$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
		$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
		$sql_atribute = array();
		if(is_array($atribute_selectare)){
			foreach ($atribute_selectare as $atribut_id => $valori) {
				$sql_atribute[] =  "articole.id IN (SELECT articol_id FROM articole_atribute WHERE valoare_id IN (".implode(", ", $valori)."))";
				// foreach ($valori as $v){
				// 	$sql_atribute[] = $v;
				// }
			}
		}
		if(is_array($sql_atribute) and count($sql_atribute)){
			$sql_atribute =  implode(" AND ", $sql_atribute);
			$sql.=" AND ".$sql_atribute;
		}
		$_pagina = ($this->per_page*$pagina);
		$produse = $this->magazin_db->produse_categorie($where_arr, array('ordine' => 'asc', 'produs_precomandabil' => 'asc', 'articole.cod' => 'asc'), array('per_page'=> $this->per_page, 'no'=>$_pagina), $sql);
		
		$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
		
		$cos = $this->cart->contents();
		$grupuri = array();
		foreach($cos as $k=>$c){
			//$produs = $this->magazin_db->produs(array('id' => $c['id']));
			$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $c['id']));
			if(is_array($art_gr) and count($art_gr))
			{
				if(isset($grupuri[$art_gr['grup_id']]['no_produse']))
					$grupuri[$art_gr['grup_id']]['no_produse'] += $c['qty'];
					else $grupuri[$art_gr['grup_id']]['no_produse'] = $c['qty'];
			}
		}

		foreach ($produse as $k => &$p) {
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p = pret_produs($p, $plafoane_reducere);
			//$produse[$k]['discount'] = array();
			//$discountVal = 0;
			//$maxDiscount = 0;
			//if( in_array($p['furnizor_id'], $this->furnizori_asociati) or !($this->session->userdata('discount')>0)){
			//	if($p['pret_intreg']<=$p['pret_vanzare']){
			//		$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
			//		//$stocuri = $this->magazin_db->produs_locatii(array('articol_id' => $p['id']));
			//		//$stoc = 0;
			//		//foreach ($stocuri as $s) {
			//		//	$stoc+=$s['stoc'];
			//		//}
			//		//$produse[$k]['stoc'] = $stoc;
			//
			//		if(count($art_gr))
			//		{
			//			//produs in grup
			//			if(isset($grupuri[$art_gr['grup_id']]))
			//			{
			//				$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
			//				if(count($discount))
			//				{
			//					$discountVal = $discount['discount'];
			//				}
			//			}
			//			$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
			//			$produse[$k]['discount'] =  $discount_grup;
			//			foreach ($produse[$k]['discount'] as $d) {
			//				if($maxDiscount < $d['discount'])
			//					$maxDiscount = $d['discount'];
			//			}
			//		} elseif(count($discount_produs = reduceriProdus($p['id']))) {
			//			$produse[$k]['discount'] = $discount_produs;
			//			$cart_item = $this->cart->find_by_id($p['id']);
			//			if(count($cart_item))
			//			{
			//				$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//				if(count($discount))
			//					$discountVal = $discount['discount'];
			//			}
			//			foreach ($produse[$k]['discount'] as $d) {
			//				if($maxDiscount < $d['discount'])
			//					$maxDiscount = $d['discount'];
			//			}
			//		} else{
			//			//reduceri generale
			//			$produse[$k]['discount'] = $plafoane_reducere;
			//			$cart_item = $this->cart->find_by_id($p['id']);
			//			if(count($cart_item))
			//			{
			//				$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//				if(count($discount))
			//					$discountVal = $discount['discount'];
			//			}
			//			foreach ($produse[$k]['discount'] as $d) {
			//				if($maxDiscount < $d['discount'])
			//					$maxDiscount = $d['discount'];
			//			}
			//		}
			//	}
			//}
			//$produse[$k]['maxDiscount'] =  $maxDiscount;
			//$produse[$k]['discountVal'] =  $discountVal;
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$p['imagine'] = $imagine;
			$p['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
			//$produse[$k]['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;	
		}
		$this->content['categorie'] = $categorie;
		$this->content['produse'] = $produse;
		$this->content['pagina'] = $pagina+1;
		$this->load->view('magazin/categorie_pagina', $this->content);
	}
	
	function categorie_subcategorii($id){
		$categorie = $this->magazin_db->categorie(array('id' => $id));
		$path = explode("-",$categorie['path']);
		if(is_array($path) and count($path)>1)
			$id_meniu = $path[1];
			else $id_meniu = $categorie['id'];
		if(is_array($path) and count($path)>2)
			$id_sub_meniu = $path[2];
		elseif(is_array($path) and count($path)==2)
			$id_sub_meniu = $categorie['id'];
		else
			$id_sub_meniu = '';
		if(count($path)>=3){
			$subcategorii = $this->magazin_db->categorii(array('id' => $categorie['id'], 'afisata' => 1), array('ordine' => 'asc'));
		} else {
			$subcategorii = $this->magazin_db->categorii(array('id_parinte' => $categorie['id'], 'afisata' => 1), array('ordine' => 'asc'));
			if(!(is_array($subcategorii) and count($subcategorii))) {
				$subcategorii = $this->magazin_db->categorii(array('id' => $categorie['id'], 'afisata' => 1), array('ordine' => 'asc'));
			}
		}

		$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
		foreach($subcategorii as &$s){
			$where_arr = array('articole_categorii.categorie_id' => $s['id'], 'articole.activ' => 1, 'articole.afisare_globiz' => 1);
			$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
			$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
			
			$produse = $this->magazin_db->produse_categorie($where_arr, array('ordine' => 'asc', 'produs_precomandabil' => 'asc', 'articole.cod' => 'asc'), array(), $sql);
			// if($s['id'] == 807){
			// 	echo $this->db->last_query();
			// }
			foreach ($produse as $k => &$p) {
				$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
				$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
				$p = pret_produs($p, $plafoane_reducere);
				//$p['discount'] = array();
				//$discountVal = 0;
				//$maxDiscount = 0;
				//if( in_array($p['furnizor_id'], $this->furnizori_asociati) or !($this->session->userdata('discount')>0)){
				//	if($p['pret_intreg']<=$p['pret_vanzare']){
				//		$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
				//		//$stocuri = $this->magazin_db->produs_locatii(array('articol_id' => $p['id']));
				//		//$stoc = 0;
				//		//foreach ($stocuri as $s) {
				//		//	$stoc+=$s['stoc'];
				//		//}
				//		//$p['stoc'] = $stoc;
				//
				//		if(count($art_gr))
				//		{
				//			//produs in grup
				//			if(isset($grupuri[$art_gr['grup_id']]))
				//			{
				//				$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
				//				if(count($discount))
				//				{
				//					$discountVal = $discount['discount'];
				//				}
				//			}
				//			$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
				//			$p['discount'] =  $discount_grup;
				//			foreach ($p['discount'] as $d) {
				//				if($maxDiscount < $d['discount'])
				//					$maxDiscount = $d['discount'];
				//			}
				//		} elseif(count($discount_produs = reduceriProdus($p['id']))) {
				//			$p['discount'] = $discount_produs;
				//			$cart_item = $this->cart->find_by_id($p['id']);
				//			if(count($cart_item))
				//			{
				//				$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
				//				if(count($discount))
				//					$discountVal = $discount['discount'];
				//			}
				//			foreach ($p['discount'] as $d) {
				//				if($maxDiscount < $d['discount'])
				//					$maxDiscount = $d['discount'];
				//			}
				//		} else{
				//			//reduceri generale
				//			$p['discount'] = $plafoane_reducere;
				//			$cart_item = $this->cart->find_by_id($p['id']);
				//			if(count($cart_item))
				//			{
				//				$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
				//				if(count($discount))
				//					$discountVal = $discount['discount'];
				//			}
				//			foreach ($p['discount'] as $d) {
				//				if($maxDiscount < $d['discount'])
				//					$maxDiscount = $d['discount'];
				//			}
				//		}
				//	}
				//}
				//$p['maxDiscount'] =  $maxDiscount;
				//$p['discountVal'] =  $discountVal;
				$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
				$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
				$p['imagine'] = $imagine;
				$p['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
				//$p['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
			}
			$s['produse'] = $produse;
		}
		
		
		$this->content['id_meniu'] = $id_meniu;
		$this->content['id_sub_meniu'] = $id_sub_meniu;
		$this->content['id_parinte'] = $categorie['id_parinte'];
		$this->content['categorie'] = $categorie;
		$this->content['subcategorii'] = $subcategorii;
		$this->layout['javascript'][] = base_url().'assets/scripts/categorie.js?v='.$this->config->item('css_js');
		$this->layout['title'] = $categorie['nume'.$this->session->userdata('fieldLang')]!=''?$categorie['nume'.$this->session->userdata('fieldLang')]:$categorie['nume'];
		$this->displayPage('magazin/categorie_subcategorii');
	}
	function produs()
	{
		$id = $this->uri->rsegment(3);
		$produs = $this->magazin_db->produs(array('id' => $id, 'magazin_id' => $this->config->item('shop_id')));
		if(!(is_array($produs) and count($produs))) {
			redirect(site_url(),'location',301);
		}
		//$stocuri = $this->magazin_db->produs_locatii(array('articol_id' => $produs['id']));
		//$stoc = 0;
		//foreach ($stocuri as $s) {
		//	$stoc+=$s['stoc'];
		//}
		//$produs['stoc'] = $stoc;
		if(($this->input->get('lang')!='') and ($this->input->cookie('language_frontend')!=$this->input->get('lang'))){
			$cookie = array(
				'name'   => 'language_frontend',
				'value'  => $this->input->get('lang'),
				'expire' => '86500'
				);
			$this->input->set_cookie($cookie);
			$this->session->set_userdata('language_frontend', $this->input->get('lang'));
			
			$urlArray = parse_url($_SERVER['REQUEST_URI']);
			$url = $urlArray['path'];
			if($urlArray['query']!=''){
				parse_str($urlArray['query'], $output);
				unset($output['lang']);
				$url.= "?".http_build_query($output);
			}
			redirect($url, 'refresh');
		}
		$produs['cantitate'] = $produs['cantitate']==0?1:$produs['cantitate'];
		$atribute_articol = $this->magazin_db->atribute_articol(array('articol_id' => $id));
		$atribute = array();
		foreach ($atribute_articol as $aa) {
			$atribute[] = array(
				'atribut' => $this->magazin_db->atribut(array('id' => $aa['atribut_id'])),
				'valoare' => $this->magazin_db->valoare(array('id' => $aa['valoare_id'])),
				);
		}
		//$categorie_id = $this->session->userdata('categorie_id');
		$categorie_id = $produs['categorie_id'];
		$cos = $this->cart->contents();
		$grupuri = array();
		foreach($cos as $k=>$c){
			//$produs = $this->magazin_db->produs(array('id' => $c['id']));
			$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $c['id']));
			if(is_array($art_gr) and count($art_gr))
			{
				if(isset($grupuri[$art_gr['grup_id']]['no_produse']))
					$grupuri[$art_gr['grup_id']]['no_produse'] += $c['qty'];
					else $grupuri[$art_gr['grup_id']]['no_produse'] = $c['qty'];
			}
		}
		$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
		//$discountVal = 0;
		//$maxDiscount = 0;
		//$produs['discount'] = array();
		//if( in_array($produs['furnizor_id'], $this->furnizori_asociati) or !($this->session->userdata('discount')>0)){
		//	if($produs['pret_intreg']<=$produs['pret_vanzare']){
		//		$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $produs['id']));
		//		if(count($art_gr))
		//		{
		//			//produs in grup
		//			if(isset($grupuri[$art_gr['grup_id']]))
		//			{
		//				$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
		//				if(count($discount))
		//				{
		//					$discountVal = $discount['discount'];
		//				}
		//			}
		//			$produs['discount'] =  $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($produs['id'])));
		//			foreach ($produs['discount'] as $d) {
		//				if($maxDiscount < $d['discount'])
		//					$maxDiscount = $d['discount'];
		//			}
		//		} elseif(count($plafon = reduceriProdus($produs['id']))) {
		//			$produs['discount'] = $plafon;
		//			$cart_item = $this->cart->find_by_id($produs['id']);
		//			if(count($cart_item))
		//			{
		//				$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $produs['id'], 'no_produse <= '=>$cart_item['qty']/$produs['cantitate']));
		//				if(count($discount))
		//					$discountVal = $discount['discount'];
		//			}
		//			foreach ($produs['discount'] as $d) {
		//				if($maxDiscount < $d['discount'])
		//					$maxDiscount = $d['discount'];
		//			}
		//		} else{
		//			//reduceri generale
		//			
		//			$produs['discount'] = $plafoane_reducere;
		//			$cart_item = $this->cart->find_by_id($produs['id']);
		//			if(count($cart_item))
		//			{
		//				$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$produs['cantitate']));
		//				if(count($discount))
		//					$discountVal = $discount['discount'];
		//			}
		//			foreach ($produs['discount'] as $d) {
		//				if($maxDiscount < $d['discount'])
		//					$maxDiscount = $d['discount'];
		//			}
		//		}
		//	}
		//}
		$produs = pret_produs($produs, $plafoane_reducere, true);
		// if($_SERVER['REMOTE_ADDR'] == '86.125.35.128'){
		// 	print_r($produs);
		// }
		//$produs['discountVal'] =  $discountVal;
		//$produs['maxDiscount'] = $maxDiscount;
		//$produs['pret_vanzare'] = $produs['pret_vanzare']-($produs['pret_vanzare']*$discountVal)/100;
		
		if($categorie_id!=0)
		{
			$categorie = $this->magazin_db->categorie(array('id' => $categorie_id));
			$path = explode("-",$categorie['path']);
			if(is_array($path) and count($path)>1)
				$id_meniu = $path[1];
				else $id_meniu = $categorie['id'];
			$this->content['id_meniu'] = $id_meniu;
		} else $this->content['id_meniu'] = categorie_parinte();
		
		
		// produse complemntare
		$articol_id = $id;
		$where = array('articol_id' => $articol_id, 'activ' => 1, 'afisare_globiz' => 1);
		$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
		//$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
		$articole_comp = $this->magazin_db->articole_complementare($where, $sql, array('rand()' => 'rand()'), array('per_page' => 5, 'no' => 0));
		if(is_array($articole_comp) and count($articole_comp)<5){
			if($produs['categorie_complementara']!=0){
				$_cat_comp_id = $produs['categorie_complementara'];
			} else {
				$_cat_comp_id = $produs['categorie_id'];
				$categorie = $this->magazin_db->categorie(array('id' => $produs['categorie_id']));
				if(isset($categorie['path'])){
					$_path = explode("-", $categorie['path']);
					if(is_array($_path) and count($_path)>=3){
						$_cat_comp_id = $_path[2];
					}
				}
			}
			$where_arr = array('articole_categorii.categorie_id' => $_cat_comp_id, 'articole.activ' => 1, 'pret_vanzare >' => 0);
			$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
			$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
			$_ids = array();
			foreach($articole_comp as $p){
				$_ids[] = $p['id'];
			}
			if(is_array($_ids) and count($_ids))
				$sql.=" AND articole.id NOT IN (".implode(", ", $_ids).")";
			$_produse = $this->magazin_db->produse_categorie($where_arr, array('articole.id' => 'random'), array('per_page'=> 5-count($articole_comp), 'no'=>0), $sql);
			$articole_comp = array_merge($articole_comp,$_produse);
		}
		//print_r(count($articole_comp));
		//exit();
		foreach ($articole_comp as $k => &$p) {
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p = pret_produs($p, $plafoane_reducere);
			//
			//$p['discount'] = array();
			//$discountVal = 0;
			//$maxDiscount = 0;
			////$stocuri = $this->magazin_db->produs_locatii(array('articol_id' => $p['id']));
			////$stoc = 0;
			////foreach ($stocuri as $s) {
			////	$stoc+=$s['stoc'];
			////}
			////$p['stoc'] = $stoc;
			//if($p['pret_intreg']<=$p['pret_vanzare']){
			//	$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
			//	if(count($art_gr))
			//	{
			//		//produsul este in grup
			//		if(isset($grupuri[$art_gr['grup_id']]))
			//		{
			//			$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
			//			if(count($discount))
			//			{
			//				$discountVal = $discount['discount'];
			//			}
			//		}
			//		$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
			//		$p['discount'] =  $discount_grup;
			//		foreach ($p['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	} elseif(count($discount_produs = reduceriProdus($p['id']))) {
			//		$p['discount'] = $discount_produs;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($p['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}else{
			//		//reduceri generale
			//		$p['discount'] = $plafoane_reducere;
			//		$cart_item = $this->cart->find_by_id($p['id']);
			//		if(count($cart_item))
			//		{
			//			$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//			if(count($discount))
			//				$discountVal = $discount['discount'];
			//		}
			//		foreach ($p['discount'] as $d) {
			//			if($maxDiscount < $d['discount'])
			//				$maxDiscount = $d['discount'];
			//		}
			//	}
			//}
			//
			//$p['maxDiscount'] =  $maxDiscount;
			//$p['discountVal'] =  $discountVal;
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$p['imagine'] = $imagine;
			$p['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
		}
		//print_r($articole_comp);exit;
		
		if($produs['tip'] == 2){ //resigilat
			$resigilat = $this->magazin_db->resigilat(array('articol_id' => $produs['id']));
			$produs['descriere'] = "<p><b>Motiv: ".$resigilat['motiv']."</b></p>".$produs['descriere'];
		}
		$this->content['complementare'] = $articole_comp;
		
		$this->content['produs'] = $produs;
		$this->content['atribute'] = $atribute;
		$this->content['categorie_id'] = $categorie_id;
		$this->content['imagini'] = $this->magazin_db->produse_imagini(array('articol_id' => $produs['id']), array('ordine' => 'asc'));
		$this->content['imagini360'] = $this->magazin_db->produse_imagini360(array('articol_id' => $produs['id']));
		
		$this->layout['current_page'] = 'produse';
		
		$this->layout['css'][] = site_url('assets/plugins/lightslider/css/lightslider.min.css');
		$this->layout['css'][] = site_url('assets/plugins/owlcarousel/assets/owl.carousel.min.css');
		$this->layout['css'][] = site_url('assets/plugins/owlcarousel/assets/owl.theme.default.css');
		$this->layout['css'][] = site_url('assets/plugins/owlcarousel/assets/owl.my_theme.css?v='.$this->config->item('css_js'));
		$this->layout['css'][] = site_url('assets/plugins/fancybox/jquery.fancybox.min.css');
		
		$this->layout['javascript'][] = site_url('assets/plugins/zoom/jquery.zoom.min.js');
		$this->layout['javascript'][] = site_url('assets/plugins/lightslider/js/lightslider.min.js');
		$this->layout['javascript'][] = site_url('assets/plugins/owlcarousel/owl.carousel.js');
		$this->layout['javascript'][] = site_url('assets/plugins/jquery.ez-plus.js');
		$this->layout['javascript'][] = site_url('assets/plugins/fancybox/jquery.fancybox.min.js');
		
		$this->layout['javascript'][] = site_url('assets/scripts/produs.js?v='.$this->config->item('css_js'));
		$this->layout['title'] = $produs['denumire'];
		if($this->agent->is_mobile()){
			$this->displayPage('mobil/magazin/produs');
		} else{
			$this->displayPage('magazin/produs');
		}
	}
	function cautare()
	{
		$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
		$cos = $this->cart->contents();
		$grupuri = array();
		foreach($cos as $k=>$c){
			//$produs = $this->magazin_db->produs(array('id' => $c['id']));
			$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $c['id']));
			if(is_array($art_gr) and count($art_gr))
			{
				if(isset($grupuri[$art_gr['grup_id']]['no_produse']))
					$grupuri[$art_gr['grup_id']]['no_produse'] += $c['qty'];
					else $grupuri[$art_gr['grup_id']]['no_produse'] = $c['qty'];

			}
		}

		$text = $this->input->get('s');
		
		$sql = '';
		$sql_array[]= "MATCH(denumire, cod, descriere) AGAINST('".$this->db->escape_like_str($text)."' IN NATURAL LANGUAGE MODE)";
		$select_arr = array();
		$select_arr[] = 'articole_cautare.*';
		$select_arr[] = "MATCH(denumire, cod, descriere) AGAINST('".$this->db->escape_like_str($text)."' IN NATURAL LANGUAGE MODE) AS relevance";
		$sql = implode(" and ", $sql_array);
        
		$where = array();
		
		$order['relevance'] = 'desc';
		$order['denumire'] = 'asc';
		
		$limits = array();
		$select = implode(", ", $select_arr);
		$query = 'SELECT articole_cautare.*, MATCH(denumire, cod, descriere) AGAINST("'.$this->db->escape_like_str($text).'" IN NATURAL LANGUAGE MODE) AS relevance FROM (articole_cautare)
		WHERE (MATCH(denumire, cod, descriere) AGAINST("'.$this->db->escape_like_str($text).'" IN NATURAL LANGUAGE MODE) OR (cod LIKE "%'.$this->db->escape_like_str($text).'%" OR denumire LIKE "%'.$this->db->escape_like_str($text).'%" OR descriere LIKE "%'.$this->db->escape_like_str($text).'%"))
		AND ((articole_cautare.stoc > 0) OR (articole_cautare.stoc_furnizor > 0 ) OR (articole_cautare.furnizor_id = 1) OR (articole_cautare.precomanda = 1))
		AND articole_cautare.afisare_globiz = 1
		ORDER BY `relevance` DESC, `denumire` ASC';
        $produse = $this->magazin_db->produse_cautare_query($query, $order, $limits);
		
        $total_produse_cautare = $this->magazin_db->total_produse_cautare($query);
		if($total_produse_cautare==0){
			$sql = "(cod LIKE '%".$text."%' OR denumire LIKE '%".$text."%') AND ((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))";
			$sql = "(cod LIKE '%".$text."%' OR denumire LIKE '%".$text."%' OR descriere LIKE '%".$text."%') AND ((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))";
			$where = array(
				'activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id')
				);
			$produse = $this->magazin_db->produse($where, array(), array(), $sql);
		}
		//echo $this->db->last_query();
		foreach ($produse as $k => &$p) {
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p = pret_produs($p, $plafoane_reducere);
			//$discountVal = 0;
			//$maxDiscount = 0;
			////$stocuri = $this->magazin_db->produs_locatii(array('articol_id' => $p['id']));
			////$stoc = 0;
			////foreach ($stocuri as $s) {
			////	$stoc+=$s['stoc'];
			////}
			////$produse[$k]['stoc'] = $stoc;
			//$p['discount'] = array();
			//if( in_array($p['furnizor_id'], $this->furnizori_asociati) or !($this->session->userdata('discount')>0)){
			//	if($p['pret_intreg']<=$p['pret_vanzare']){
			//		$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
			//		if(count($art_gr))
			//		{
			//			//produs in grup
			//			if(isset($grupuri[$art_gr['grup_id']]))
			//			{
			//				$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
			//				if(count($discount))
			//				{
			//					$discountVal = $discount['discount'];
			//				}
			//			}
			//			$p['discount'] =  $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
			//			foreach ($p['discount'] as $d) {
			//				if($maxDiscount < $d['discount'])
			//					$maxDiscount = $d['discount'];
			//			}
			//		} elseif(count($plafon = reduceriProdus($p['id']))) {
			//			$produse[$k]['discount'] = $plafon;
			//			$cart_item = $this->cart->find_by_id($p['id']);
			//			if(count($cart_item))
			//			{
			//				$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//				if(count($discount))
			//					$discountVal = $discount['discount'];
			//			}
			//			foreach ($produse[$k]['discount'] as $d) {
			//				if($maxDiscount < $d['discount'])
			//					$maxDiscount = $d['discount'];
			//			}
			//		} else{
			//			//reduceri generale
			//			$p['discount'] = $plafoane_reducere;
			//			$cart_item = $this->cart->find_by_id($p['id']);
			//			if(count($cart_item))
			//			{
			//				$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
			//				if(count($discount))
			//					$discountVal = $discount['discount'];
			//			}
			//			foreach ($produse[$k]['discount'] as $d) {
			//				if($maxDiscount < $d['discount'])
			//					$maxDiscount = $d['discount'];
			//			}
			//		}
			//	}
			//}
			//$p['discountVal'] =  $discountVal;
			//$p['maxDiscount'] = $maxDiscount;
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$p['imagine'] = $imagine;
			$p['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
			//$produse[$k]['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
		}
		$this->content['produse'] = $produse;
		
		//$this->layout['javascript'][] = base_url().THEMESFOLDER.'js/cautare.js';
		$this->layout['content'] = $this->load->view('magazin/cautare', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	
	function produse_oferta(){
		$tip = $this->uri->rsegment(3);
		$ordine = array();
		$where = array();
		$sql = '';
		$sql_arr = array();
		// $banner = array();
		switch ($tip) {
			case 'promotii':
				$where = array('activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
				$sql_arr[] = "(promo=1 or lichidari=1)";
				// $sql_arr[] = "(lichidari=1)";
				$titlu = lang('promotii');
				$ordine = array('data_articol_promo' => 'desc', 'id' => 'desc');
				$sql_arr[] = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
				$sql = implode(" AND ", $sql_arr);
				$produse = $this->magazin_db->produse($where, $ordine, array('per_page'=> $this->per_page, 'no'=>0), $sql);
				$banner = $this->magazin_db->banner(array('tip' => 3));
				break;
			case 'lichidari':
				$titlu = lang('lichidari');
				$id = $this->categorie_resigilate_id;
				$categorie = $this->magazin_db->categorie(array('id' => $id));
				$where_arr = array('articole_categorii.categorie_id' => $id, 'articole.activ' => 1, 'articole.afisare_globiz' => 1);
				$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
				$produse = $this->magazin_db->produse_categorie($where_arr, array('ordine' => 'asc', 'produs_precomandabil' => 'asc', 'articole.cod' => 'asc'), array('per_page'=> $this->per_page, 'no'=>0), $sql);
				$banner = $this->magazin_db->banner(array('tip' => 1));
				break;
			default:
				$where = array('nou' => '1', 'activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
				$titlu = lang('noutati');
				$ordine = array('data_articol_nou' => 'desc', 'id' => 'desc');
				$sql_arr[] = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
				$sql = implode(" AND ", $sql_arr);
				$produse = $this->magazin_db->produse($where, $ordine, array('per_page'=> $this->per_page, 'no'=>0), $sql);
				$banner = $this->magazin_db->banner(array('tip' => 2));
				break;
		}
		//$where['articole.stoc > '] = 0;
		// $sql = '((articole.stoc > 0) OR (articole.stoc_furnizor >0 ))';
		
		// echo $this->db->last_query();
		$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
		
		$cos = $this->cart->contents();
		$grupuri = array();
		foreach($cos as $k=>$c){
			//$produs = $this->magazin_db->produs(array('id' => $c['id']));
			$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $c['id']));
			if(is_array($art_gr) and count($art_gr))
			{
				if(isset($grupuri[$art_gr['grup_id']]['no_produse']))
					$grupuri[$art_gr['grup_id']]['no_produse'] += $c['qty'];
					else $grupuri[$art_gr['grup_id']]['no_produse'] = $c['qty'];
			}
		}
		foreach ($produse as $k => &$p) {
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p = pret_produs($p, $plafoane_reducere);
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$p['imagine'] = $imagine;
			$p['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
			//$p['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
		}
		//$s['produse'] = $produse;
		
		
		
		$this->content['produse'] = $produse;
		$this->content['titlu'] = $titlu;
		//$this->content['subcategorii'] = $this->magazin_db->categorii(array('id_parinte' => $id), array('ordine' => 'asc'));
		
		$this->content['pagina'] = 1;
		$this->content['tip'] = $tip;
		$this->content['banner'] = $banner;

		$this->layout['current_page'] = 'produse_oferta';
		$this->layout['javascript'][] = base_url().'assets/plugins/infinite-scroll.min.js';
		$this->layout['javascript'][] = base_url().'assets/scripts/oferte.js?v='.$this->config->item('css_js');
		$this->displayPage('magazin/produse_oferta');
	}
	function produse_oferta_pagina(){
		$tip = $this->uri->rsegment(3);
		$ordine = array();
		$where = array();
		$sql = '';
		$sql_arr = array();
		$pagina = $this->uri->segment(4);
		$_pagina = ($this->per_page*$pagina);
		switch ($tip) {
			case 'promotii':
				$where = array('activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
				$sql_arr[] = "(promo=1 or lichidari=1)";
				// $sql_arr[] = "(lichidari=1)";
				$titlu = lang('promotii');
				$ordine = array('data_articol_promo' => 'desc', 'id' => 'desc');
				$sql_arr[] = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
				$sql = implode(" AND ", $sql_arr);

				$produse = $this->magazin_db->produse($where, $ordine, array('per_page'=> $this->per_page, 'no'=>$_pagina), $sql);
				break;
			case 'lichidari':
				// $where = array('lichidari' => '1', 'activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
				// $titlu = lang('lichidari');
				// $ordine = array('data_articol_lichidari' => 'desc', 'id' => 'desc');
				$titlu = lang('lichidari');
				$id = $this->categorie_resigilate_id;
				$categorie = $this->magazin_db->categorie(array('id' => $id));
				$where_arr = array('articole_categorii.categorie_id' => $id, 'articole.activ' => 1, 'articole.afisare_globiz' => 1);
				$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
				$produse = $this->magazin_db->produse_categorie($where_arr, array('ordine' => 'asc', 'produs_precomandabil' => 'asc', 'articole.cod' => 'asc'), array('per_page'=> $this->per_page, 'no'=>$_pagina), $sql);
				// echo $this->db->last_query();
				break;
			default:
				$where = array('nou' => '1', 'activ' => 1, 'afisare_globiz' => 1, 'magazin_id' => $this->config->item('shop_id'));
				$titlu = lang('noutati');
				$ordine = array('data_articol_nou' => 'desc', 'id' => 'desc');
				$sql_arr[] = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
				$sql = implode(" AND ", $sql_arr);
				$produse = $this->magazin_db->produse($where, $ordine, array('per_page'=> $this->per_page, 'no'=>$_pagina), $sql);
				break;
		}
		//$where['articole.stoc > '] = 0;
		$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
		
		$cos = $this->cart->contents();
		$grupuri = array();
		foreach($cos as $k=>$c){
			//$produs = $this->magazin_db->produs(array('id' => $c['id']));
			$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $c['id']));
			if(is_array($art_gr) and count($art_gr))
			{
				if(isset($grupuri[$art_gr['grup_id']]['no_produse']))
					$grupuri[$art_gr['grup_id']]['no_produse'] += $c['qty'];
					else $grupuri[$art_gr['grup_id']]['no_produse'] = $c['qty'];
			}
		}

		// foreach ($produse as $k => $p) {
		// 	$discountVal = 0;
		// 	$maxDiscount = 0;

		// 	//$stocuri = $this->magazin_db->produs_locatii(array('articol_id' => $p['id']));
		// 	//$stoc = 0;
		// 	//foreach ($stocuri as $s) {
		// 	//	$stoc+=$s['stoc'];
		// 	//}
		// 	//$produse[$k]['stoc'] = $stoc;
		// 	$produse[$k]['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
		// 	$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
		// 	if($p['pret_intreg']<=$p['pret_vanzare']){
		// 		$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $p['id']));
		// 		if(count($art_gr))
		// 		{
		// 			//produs in grup
		// 			if(isset($grupuri[$art_gr['grup_id']]))
		// 			{
		// 				$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
		// 				if(count($discount))
		// 				{
		// 					$discountVal = $discount['discount'];
		// 				}
		// 			}
		// 			$produse[$k]['discount'] =  $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($p['id'])));
		// 			foreach ($produse[$k]['discount'] as $d) {
		// 				if($maxDiscount < $d['discount'])
		// 					$maxDiscount = $d['discount'];
		// 			}
		// 		} elseif(count($plafon = reduceriProdus($p['id']))) {
		// 			$produse[$k]['discount'] = $plafon;
		// 			$cart_item = $this->cart->find_by_id($p['id']);
		// 			if(count($cart_item))
		// 			{
		// 				$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $p['id'], 'no_produse <= '=>$cart_item['qty']/$p['cantitate']));
		// 				if(count($discount))
		// 					$discountVal = $discount['discount'];
		// 			}
		// 			foreach ($produse[$k]['discount'] as $d) {
		// 				if($maxDiscount < $d['discount'])
		// 					$maxDiscount = $d['discount'];
		// 			}
		// 		} else{
		// 			//reduceri generale
		// 			$produse[$k]['discount'] = $plafoane_reducere;
		// 			$cart_item = $this->cart->find_by_id($p['id']);
		// 			if(count($cart_item))
		// 			{
		// 				$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cart_item['qty']/$p['cantitate']));
		// 				if(count($discount))
		// 					$discountVal = $discount['discount'];
		// 			}
		// 			foreach ($produse[$k]['discount'] as $d) {
		// 				if($maxDiscount < $d['discount'])
		// 					$maxDiscount = $d['discount'];
		// 			}
		// 		}
		// 	} else {
		// 		$produse[$k]['discount'] = array();
		// 	}
		// 	$produse[$k]['discountVal'] =  $discountVal;
		// 	$produse[$k]['maxDiscount'] = $maxDiscount;
		// 	//$produse[$k]['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
		// 	//$produse[$k]['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
		// 	$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
		// 	$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
		// 	$produse[$k]['imagine'] = $imagine;
		// 	$produse[$k]['imagine2'] = count($imagine2)?$imagine2:$imagine;
			
		// }
		foreach ($produse as $k => &$p) {
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p['cantitate'] = $p['cantitate']==0?1:$p['cantitate'];
			$p = pret_produs($p, $plafoane_reducere);
			$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
			$imagine2 = $this->magazin_db->produse_imagine(array('articol_id' => $p['id'], 'id !=' => $imagine['id']), array('ordine' => 'asc'));
			$p['imagine'] = $imagine;
			$p['imagine2'] = (is_array($imagine2) and count($imagine2))?$imagine2:$imagine;
			//$p['pret_vanzare'] = $p['pret_vanzare']-($p['pret_vanzare']*$discountVal)/100;
		}
		$this->content['produse'] = $produse;
		$this->content['tip'] = $tip;
		$this->content['pagina'] = $this->per_page+$pagina;
		$this->load->view('magazin/produse_oferta_pagina', $this->content);
	}


	function autosugestion_cod()
	{
		$str = $this->input->post('text');

		//$where_arr = array('activ' => 1);
		$where_arr = array();
		$limits = array();
		$order = array('denumire' => 'asc', 'id'=>'asc');
		
		$sql = "(cod LIKE '%".$str."%')";

		$articole = $this->magazin_db->produse($where_arr, $order, $limits, $sql);
		$respons = array();
		foreach ($articole as $a) {
			$name = $a['denumire'];
			$cod = $a['cod'];
			$respons[] = array(
				'value' => $cod,
				'id'    => $a['id']
				);
		}
		echo json_encode($respons);
	}

	function schimba_limba()
	{
		$lang = $this->input->post('lang');
		$cookie = array(
			'name'   => 'language_frontend',
			'value'  => $lang,
			'expire' => '86500'
			);
		$this->input->set_cookie($cookie);
		$this->session->set_userdata('language_frontend', $lang);
	}
	
	function catalog(){
		$id = $this->uri->rsegment(3);
		$catalog = $this->magazin_db->catalog(array('id' => $id));
		$this->content['catalog'] = $catalog;
		$this->layout['content'] = $this->load->view('catalog', $this->content, true);
		$this->layout['title'] = $catalog['denumire'.$this->session->userdata('fieldLang')]==''?$catalog['denumire']:$catalog['denumire'.$this->session->userdata('fieldLang')];
		
		$this->load->view('layout', $this->layout);
	}
	function test($id){
		$produs = $this->magazin_db->produs(array('id' => $id, 'magazin_id' => $this->config->item('shop_id')));
		$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
		$produs = pret_produs($produs, $plafoane_reducere);
		print_R($produs);
	}
	function test2(){
		echo $this->config->item('media_path');
	}
	function test3(){
		echo '<pre>';
		print_r(categorii_top_new());
	}

	function inchide_ms_cookie(){
        $value = $this->input->post('tip') == 'acord'?1:0;
        $cookie = array(
            'name'   => 'globiz_ms_cookie',
            'value'  => $value,
            'expire' => time()+108000,
            'path'   => '/'
            );
        $this->input->set_cookie($cookie);
	}
	
}