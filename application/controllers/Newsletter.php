<?
class Newsletter extends MY_Controller
{
	var $layout, $content;
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('newsletter_db', 'magazin_db'));
		$this->load->helper('text');
	}
	
	function index() {
		
	}
	function preview($id){
		$newsletter = $this->newsletter_db->newsletter(array('id' => $id));
		$articole = $this->newsletter_db->continut(array('newsletter_id' => $id), array('pozitie' =>'asc'));
		$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
		foreach($articole as &$a){
			$articol = $this->magazin_db->produs(array('id' => $a['articol_id']));
			$articol['discount'] = array();
			if($this->config->item('blackfriday')){
				$tip_tert = 1;
			} else {
				$tip_tert = 4;
			}
			//echo $articol['denumire'].'<br>';
			//echo $articol['pret_intreg'].' - '.$articol['pret_vanzare'];
			//echo '<br>';
			$articol = pret_produs($articol, $plafoane_reducere, false, $tip_tert);
			//echo $articol['pret_intreg'].' - '.$articol['pret_vanzare'];
			//exit();
			// $discountVal = 0;
			// $maxDiscount = 0;
			// if($articol['pret_intreg']<=$articol['pret_vanzare']){
			// 	if($tip_tert== 4 ){
			// 	} else {
			// 		$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $articol['id']));
			// 		if(count($art_gr))
			// 		{
			// 			//produsul este in grup
			// 			if(isset($grupuri[$art_gr['grup_id']]))
			// 			{
			// 				$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$grupuri[$art_gr['grup_id']]['no_produse']));
			// 				if(count($discount))
			// 				{
			// 					$discountVal = $discount['discount'];
			// 				}
			// 			}
			// 			$discount_grup = $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($articol['id'])));
			// 			$articol['discount'] =  $discount_grup;
			// 			foreach ($articol['discount'] as $d) {
			// 				if($maxDiscount < $d['discount'])
			// 					$maxDiscount = $d['discount'];
			// 			}
			// 		} elseif(count($discount_produs = reduceriProdus($articol['id']))) {
			// 			$articol['discount'] = $discount_produs;
			// 			$cart_item = $this->cart->find_by_id($articol['id']);
			// 			foreach ($articol['discount'] as $d) {
			// 				if($maxDiscount < $d['discount'])
			// 					$maxDiscount = $d['discount'];
			// 			}
			// 		}else{
			// 			//reduceri generale
			// 			$articol['discount'] = $plafoane_reducere;
						
			// 			foreach ($articol['discount'] as $d) {
			// 				if($maxDiscount < $d['discount'])
			// 					$maxDiscount = $d['discount'];
			// 			}
			// 		}
			// 	}
			// }
			// $articol['maxDiscount'] =  $maxDiscount;
			// $articol['discountVal'] =  $discountVal;
			$a['articol'] = $articol;
			$img = $this->magazin_db->produse_imagine(array('articol_id' => $a['articol_id']), array('ordine' => 'asc'));
			$a['imagine'] = isset($img['imagine'])?$img['imagine']:'';
		}
		$this->content['newsletter'] = $newsletter;
		$this->content['articole'] = $articole;
		$this->load->view('newsletter/preview', $this->content);
	}
}