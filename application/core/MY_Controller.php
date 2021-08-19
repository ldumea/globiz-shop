<?php
class MY_Controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->layout = array();
		$this->content = array();
		$this->per_page = 30;

		$this->content['per_page'] = $this->per_page;

		$this->content['moneda'] = 'RON';
		$this->content['curs'] = 1;
		$this->content['tara'] = 'RO';
		$this->companie_tva = 19;
		$this->content['produse_cadou'] = $this->config->item('produse_cadou');
		$this->content['suma_produse_cadou'] = $this->config->item('suma_produse_cadou');
		
		$this->furnizori_asociati = $this->config->item('furnizori_asociati');
		$_c = $this->input->cookie('LoginGlobiz', true);
		if($_c!=''){
			$this->load->model(array('utilizator_db'));
			$rec = array(
				'id'		=> $_c,
				'activ'		=> 1,
				'confirmat'	=> 1,
				'magazin'	=> 'globiz'
			);
			$utilizator = $this->utilizator_db->utilizator($rec);
			if(count($utilizator)){
				$tert = $this->utilizator_db->tert(array('id' => $utilizator['tert_id']));
				$sess = array(
					'loggedFrontend'	=> true,
					'nume'				=> $utilizator['delegat'],
					'tert_id'			=> $utilizator['tert_id'],
					'id'				=> $utilizator['id'],
					'utilizator'		=> $utilizator['utilizator'],
					'email'				=> $utilizator['email'],
					'valoare_tva'		=> $tert['valoare_tva'],
					'discount'			=> $tert['fara_discount']==1?-1:($tert['discount']==0?-1:$tert['discount']),
					'tip_pret'			=> $tert['tip_pret'],
					'feed_activ'		=> $tert['feed_activ'],
					'tara'				=> $tert['tara'],
					'dropshipping'		=> $tert['dropshipping'],
					'gdpr'				=> $utilizator['gdpr'],
					'magazin'			=> 'globiz'
				);
				$this->session->set_userdata($sess);
			}
		}
		if($this->session->userdata('loggedFrontend')){
			// $this->lang->load('filename', 'language');
			$lang = $this->session->userdata('language_frontend');
			switch($lang)
			{
				case 'en':
					$this->lang->load('globiz', 'english');
					break;
				default:
					$this->lang->load('globiz', 'romanian');
					break;
			}	
				// if($this->session->userdata('data_actualizare_info_facturi') != date('Y-m-d')){
				//verificare facturi scadente neplatite
				$sold = 0;
				$this->load->model(array('facturi_db'));
				$facturi = $this->facturi_db->facturi(array('tert_id' => $this->session->userdata('tert_id'), 'stare'=>1, 'data_scadenta <= '=>date('Y-m-d').' 23:59:59'));
				foreach($facturi as $f){
					// $factura_continut = $this->facturi_db->continut(array('factura_id' => $f['id']));
					$total = $f['total'];
					// $valoare = 0;
					$platit = 0;
					// foreach ($factura_continut as $cont) {
					// 	$total +=$cont['total'];
					// 	$valoare +=$cont['valoare'];
					// }
					$plati_total = $this->facturi_db->plati(array('factura_id' => $f['id'], 'sters' => 0));
					foreach ($plati_total as $p) {
						$platit += $p['suma'];
					}
		
					$sold = $sold+ ($total-$platit);
				}
				$this->session->set_userdata('data_actualizare_info_facturi', date('Y-m-d'));
				$this->session->set_userdata('sold', $sold);
			// }
			$this->content['tara'] = $this->session->userdata('tara');
			if($this->session->userdata('tara')!='RO'){
				$this->content['moneda'] = 'Euro';
				$this->content['curs'] = $this->config->item('curs_en');
			} else {
				$this->content['moneda'] = 'RON';
				$this->content['curs'] = 1;
			}
			$this->session->set_userdata('moneda', $this->content['moneda']);
			
			if($this->cart->total_items() == 0){
				$this->load->model(array('utilizator_db'));
				$utilizator = $this->utilizator_db->utilizator(array('id' => $this->session->userdata('id')));
				$cos = $utilizator['cos'];
				$cos_arr = unserialize($cos);
				//print_R($cos_arr);
				if(is_array($cos_arr) and count($cos_arr)){
					foreach ($cos_arr as $c) {
						$_produs = $this->magazin_db->produs(array('id' => $c['id']));
						//print_r($c);
						if(count($_produs)){
							if( isset($c['options']) and count($c['options']) ) {
								$options = $c['options'];
							} else {
								$_produs = $this->magazin_db->produs(array('id' => $c['id']));
								if(count($_produs)){
									$options = array('cod' => $_produs['cod']);
								} else {
									$options = array('cod' => '');
								}
							}
							$data_cos = array(
								'id'      => $c['id'],
								'qty'     => $c['qty'],
								'price'   => $c['price'],
								'name'    => $c['name'],
								'options' => /*array('cod' => count($produs)?$produs['cod']:'')*/ $options
							);
							$this->cart->insert($data_cos);
						}
					}
				}
			}
			discount_negociat();
		}
		$this->content['folder'] = $this->session->userdata('folderView')==''?'':$this->session->userdata('folderView').'/';
		//if($this->agent->is_mobile()){
			$categorii_mobil_meniu = categorii_meniu_submeniu();
			$this->content['categorii_mobil_meniu'] = $categorii_mobil_meniu;
		//}
	}
	function displayPage($page = '') {
		if($page !='')
			$this->layout['content'] = $this->load->view($page, $this->content, true);
		$this->load->view('layout', $this->layout);
	}
}