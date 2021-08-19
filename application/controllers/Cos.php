<?
class Cos extends MY_Controller
{
	var $layout, $content;
	function __construct()
	{
		parent::__construct();
		
		$this->layout['show_slider'] = false;
		$this->layout['large'] = true;
		$this->load->model('utilizator_db');
		if($this->content['tara'] == 'RO')
			$this->cos_transport = 500;
		else
			$this->cos_transport = 1000;
		$this->load->library('parser');
	}
	
	function index()
	{
		//$this->cart->destroy();
		$utilizator = $this->utilizator_db->utilizator(array('id' => $this->session->userdata('id')));
		$cos = $utilizator['cos'];
		$cos_arr = unserialize($cos);
		if(is_array($cos_arr) and count($cos_arr)){
			foreach ($cos_arr as $c) {
				$produs = $this->magazin_db->produs(array('id' => $c['id']));
				//print_r($c);
				if(count($produs)){
					if( isset($c['options']) and count($c['options']) ) {
						$options = $c['options'];
					} else {
						$produs = $this->magazin_db->produs(array('id' => $c['id']));
						if(count($produs)){
							$options = array('cod' => $produs['cod']);
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
		$cart = $this->cart->contents();
		
		//print_R($cart);
		//exit();
		$cos = array();
		foreach($cart as $k=>$c){
			$produs = $this->magazin_db->produs(array('id' => $c['id']));
			if(count($produs)){
				$produs['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $produs['id']), array('ordine' => 'asc'));
				$cos[$k] = $c;
				$cos[$k]['url'] = produs_url($produs);
				$cos[$k]['produs'] = $produs;
				$cos[$k]['tva'] = $this->session->userdata('valoare_tva')==0?$this->session->userdata('valoare_tva'):$produs['tva'];
			}
		}
		$this->content['cos'] = $cos;
		$this->content['voucher'] = $this->voucher();
		$this->content['transport'] = $this->transport();
		$this->content['discount'] = $this->discount();
		$this->content['discount_produs_cadou'] = $this->discount_produs_cadou();
		$this->content['cos_transport'] = $this->cos_transport;
		$this->content['error'] = $this->session->flashdata('error');
		$this->content['error'] = $this->load->view('error', $this->content, true);
		$this->content['error_cupon'] = $this->session->flashdata('error_cupon');
		$this->displayPage('cos/cos');
	}
	function discount(){
		// $cos = $this->cart->contents();
		// $discount = array();
		// $total_cos = 0;
		// foreach ($cos as $c) {
		// 	if(!(isset($c['options']['furnizor_id']) and in_array($c['options']['furnizor_id'], $this->furnizori_asociati))){
		// 		if(($c['id']!='voucher') or ($c['id']!='transport')){
		// 			$produs = $this->magazin_db->produs(array('id' => $c['id']));
		// 			if(count($produs)){
		// 				$total_cos += $c['subtotal']*(100+$produs['tva'])/100;
		// 			}
		// 		}
		// 	}
		// }
		// if($total_cos>0){
		// 	$item = $this->cart->find_by_id('discount');
		// 	if($item){	
		// 		//actualizare
		// 		$discount_valoare = $this->session->userdata('discount');
		// 		$discount_total = $total_cos*$discount_valoare/100;
		// 		$data = array(
		// 			'rowid' => $item['rowid'],
		// 			'price'	=> $discount_total*100/(100+$this->companie_tva),
		// 			);
		// 		$this->cart->update_price($data);
		// 		$discount = $this->cart->find_by_id('discount');
		// 		$discount['tva'] = $this->companie_tva;
		// 	} else {
		// 		//adauga
		// 		if(count($cos)){
		// 			$discount_valoare = $this->session->userdata('discount');
		// 			if($discount_valoare>0){
		// 				$discount_total = $total_cos*$discount_valoare/100;
		// 				$data = array(
		// 					'id'      => 'discount',
		// 					'qty'     => -1,
		// 					'price'   => $discount_total*100/(100+$this->companie_tva),
		// 					'name'    => lang('discount_negociat_la_contract'),
		// 					'options' => array(
		// 							'info' 	=> 'discount',
		// 							'cod'	=> '709'
		// 						)
		// 					);
		// 				$this->cart->insert($data);
		// 				$discount = $item = $this->cart->find_by_id('discount');
		// 				$discount['tva'] = $this->companie_tva;
		// 			}
		// 		} else {
		// 			$discount = array();
		// 		}
		// 	}
		// } else {
		// 	$item = $this->cart->find_by_id('discount');
		// 	if($item){
		// 		//actualizare
		// 		$transport = $item;
		// 		$data = array(
		// 			'rowid' => $item['rowid'],
		// 			'qty'	=> 0
		// 		);
		// 		$this->cart->update($data);
		// 	}
		// }
		// return $discount;
		return discount_negociat();
	}
	function discount_produs_cadou(){
		$discount = $this->cart->find_by_id('discount_produse_cadou');
		if($discount){
			$produs_id = $this->cart->find_by_options('tip', 'produs_cadou');
			$produs = $this->magazin_db->produs(array('id' => $produs_id));
			$discount['tva'] = $this->session->userdata('valoare_tva')==0?$this->session->userdata('valoare_tva'):$produs['tva'];
		} else {
			$discount = array();
		}
		return $discount;
	}
	function _adauga_transport(){
		$cos = $this->cart->contents();
		$transport = array();
		$total_cos = 0;
		if($this->content['tara']=='RO'){
			foreach ($cos as $c) {
				if(!(isset($c['options']['furnizor_id']) and in_array($c['options']['furnizor_id'], $this->furnizori_asociati))){
					if(($c['id']!='voucher') and ($c['id']!='transport')){
						$produs = $this->magazin_db->produs(array('id' => $c['id']));
						if(count($produs)){
							$total_cos += $c['subtotal']*(100+$produs['tva'])/100;
						} else {
							$total_cos += $c['subtotal']*(100+$this->companie_tva)/100;
						}
					}
				}
			}
			if($total_cos>0){
				$item = $this->cart->find_by_id('transport');
				if($item){
					//actualizare
					$transport = $item;
					$transport['tva'] = $this->companie_tva;
					if(($total_cos>=$this->cos_transport) or ($total_cos == 0)){
						$data = array(
							'rowid' => $item['rowid'],
							'qty'	=> 0
						);
						$this->cart->update($data);
						$transport = array();
					}
				} else {
					//adauga
					if($total_cos){
						if($total_cos<$this->cos_transport){
							$produs = $this->magazin_db->produs(array('cod' => '704'));
							$data = array(
								'id'      => 'transport',
								'qty'     => 1,
								'price'   => $produs['pret_vanzare'],
								'name'    => $produs['denumire'],
								'options' => array(
										'info' 	=> 'transport',
										'cod'	=> $produs['cod']
									)
								);
							$this->cart->insert($data);
							$transport = $item = $this->cart->find_by_id('transport');
							$transport['tva'] = $this->companie_tva;
						}
					} else {
						$transport = array();
					}
				}
			} else {
				$item = $this->cart->find_by_id('transport');
				if($item){
					//actualizare
					$transport = $item;
					$data = array(
						'rowid' => $item['rowid'],
						'qty'	=> 0
					);
					$this->cart->update($data);
				}
			}
		}
		return $transport;
	}
	function transport(){
		$transport = array();
		if($this->session->userdata('dropshipping')!=1){
			$transport = $this->_adauga_transport();
		}
		return $transport;
	}
	function voucher(){
		$return = array();
		$item = $this->cart->find_by_id('voucher');
		if($item){
			$return = $item;
			$return['tva'] = $this->companie_tva;
			$cod = isset($item['options']['cod'])?$item['options']['cod']:'';
			if($cod!=''){
				$raspuns = $this->voucher_test($cod);
				if(!$raspuns['tip']){
					$data = array(
						'rowid' => $item['rowid'],
						'qty'	=> 0
					);
					$this->cart->update($data);
					$return = array();
				}
			}
		}
		// print_r($voucher);
		// print_r($this->cart->contents());
		return $return;
	}

	function adauga_cupon(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('voucher', 'Cupon', 'trim|required|callback_verificarevoucher');
		$raspuns = array();
		if ($this->form_validation->run() == FALSE) {
			$this->content['error_txt'] = validation_errors();
			$raspuns['tip'] = 'eroare';
			$raspuns['msg'] = $this->load->view('error', $this->content, true);
		} else {
			$raspuns['tip'] = 'ok';
		}
		echo json_encode($raspuns);
	}
	function verificarevoucher(){
		$cod = $this->input->post('voucher');
		$raspuns = $this->voucher_test($cod);
		if($raspuns['tip']){

			$voucher = $raspuns['voucher'];
			$cos = $this->cart->contents();
			$conditie = $voucher['conditie'];
			$valoare = (float)$voucher['valoare'];
			$tip_discount = $voucher['discount_tip'];
			$discount_valoare = $voucher['discount_valoare'];
			$total_cos = $this->cart->total();
			$discount_total = $tip_discount==1?$total_cos*$discount_valoare/100:$discount_valoare;
			$data = array(
				'id'      => 'voucher',
				'qty'     => -1,
				'price'   => $discount_total*100/(100+$this->companie_tva),
				'name'    => lang('reducere_cod').' '.$cod.')',
				'options' => array(
						'info' 	=> 'voucher',
						'cod'	=> $cod
					)
				);
			$this->cart->insert($data);
			return TRUE;
		} else {
			$this->form_validation->set_message('verificarevoucher', $raspuns['msg']);
			return FALSE;
		}
	}
	function voucher_test($cod){
		$voucher = $this->magazin_db->voucher(array('cod' => $cod));
		$return = false;
		$msg = lang('cupon_discount_nu_exista');
		if(count($voucher)){

			if($voucher['tip_utilizare']==1){
				$voucher_utilizat = $this->magazin_db->voucher_utilizat(array('voucher_id' => $voucher['id']));
			} else {
				$voucher_utilizat = $this->magazin_db->voucher_utilizat(array('voucher_id' => $voucher['id'], 'utilizator_id' => $this->session->userdata('id')));
			}
			if(is_array($voucher_utilizat) and count($voucher_utilizat)){
				$msg = lang('cupon_utilizat');
			} else {
				if($voucher['data_expirare'] >= date('Y-m-d')){
					$cos = $this->cart->contents();
					$conditie = $voucher['conditie'];
					$valoare = (float)$voucher['valoare'];
					$tip_discount = $voucher['discount_tip'];
					$discount_valoare = $voucher['discount_valoare'];
					switch ($voucher['tip']) {
						case 'total_cos': //cu TVA
							$total_cos = 0;
							// foreach ($cos as $c) {
							// 	if($c['id']!='voucher'){
							// 		$produs = $this->magazin_db->produs(array('id' => $c['id']));
							// 		if(count($produs)){
							// 			$total_cos += $c['subtotal']*(100+$produs['tva'])/100;
							// 		}
							// 	}
							// }
							foreach ($cos as $c) {
								if(!(isset($c['options']['furnizor_id']) and in_array($c['options']['furnizor_id'], $this->furnizori_asociati))){
									if(($c['id']!='voucher') and ($c['id']!='transport')){
										$produs = $this->magazin_db->produs(array('id' => $c['id']));
										if(count($produs)){
											$total_cos += $c['subtotal']*(100+$produs['tva'])/100;
										} else {
											$total_cos += $c['subtotal']*(100+$this->companie_tva)/100;
										}
									}
								}
							}
							$total_cos = round($total_cos, 2);
							switch ($conditie) {
								case '=': // 'Egal',
									if($total_cos == $valoare){
										$return = true;
									} else {
										$return = false;
										$msg = lang('sum_bruta_egala').$valoare;
									}
									break;
								case '!=': // 'Diferit',
									if($total_cos != $valoare){
										$return = true;
									} else {
										$return = false;
										$msg = lang('sum_bruta_diferita').$valoare;
									}
									break;
								case '<': // 'Mai mic',
									if($total_cos < $valoare){
										$return = true;
									} else {
										$return = false;
										$msg = lang('sum_bruta_mica').$valoare;
									}
									break;
								case '<=': // 'Mai mic sau egal',
									if($total_cos <= $valoare){
										$return = true;
									} else {
										$return = false;
										$msg = lang('sum_bruta_mica_egala').$valoare;
									}
									break;
								case '>': // 'Mai mare',
									if($total_cos > $valoare){
										$return = true;
									} else {
										$return = false;
										$msg = lang('sum_bruta_mare').$valoare;
									}
									break;
								case '>=': // 'Mai mare sau egal'
									if($total_cos >= $valoare){
										$return = true;
									} else {
										$return = false;
										$msg = lang('sum_bruta_mare_egala').$valoare;
									}
									break;
							}
							break;
						default:
							$return = FALSE;
							break;
					}
				} else {
					$msg = lang('cupon_expirat');
				}
			}
		}
		$raspuns = array('tip' => false, 'msg' => '');
		if($return){
			$raspuns = array('tip' => true, 'voucher' => $voucher);
			//return $voucher;
		} else {
			$raspuns = array('tip' => false, 'msg' => $msg);
		}
		return $raspuns;
	}
	function sterge_voucher(){
		$item = $this->cart->find_by_id('voucher');
		if($item){
			$data = array(
				'rowid' => $item['rowid'],
				'qty'   => 0
			);
			$this->cart->update($data);
		}
	}
	function sterge_transport(){
		$item = $this->cart->find_by_id('transport');
		if($item){
			$data = array(
				'rowid' => $item['rowid'],
				'qty'   => 0
			);
			$this->cart->update($data);
		}
	}
	function sterge_discount(){
		$item = $this->cart->find_by_id('discount');
		if($item){
			$data = array(
				'rowid' => $item['rowid'],
				'qty'   => 0
			);
			$this->cart->update($data);
		}
	}
	
	function actualizeaza_cos(){
		$cartid = $this->input->post('id');
		$qty = $this->input->post('qty');
		$items = $this->cart->contents();
		$item = $items[$cartid];
		$produs = $this->magazin_db->produs(array('id' => $item['id']));
		$result['res'] = 'error';
		if($qty%$produs['cantitate']==0)
		{
			$result['res'] = 'ok';
			
			$data = array(
				'rowid' => $cartid,
				'qty'   => $qty
			);
			$this->cart->update($data);
			
			$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
			$pret_special = $this->magazin_db->pret_special(array('articol_id' => $produs['id'], 'tert_id' => $this->session->userdata('tert_id')));
			
			if(!count($pret_special)){
				if($this->session->userdata('discount')==-1){
					switch($this->session->userdata('tip_pret')){
						case 2:
						case 3:
						case 4:
							$cart_item = $this->cart->find_by_id($produs['id']);
							$produs = pret_produs($produs, $plafoane_reducere);
							$data = array(
								'rowid' => $cart_item['rowid'],
								'price'   => round($produs['pret_vanzare']/$this->content['curs'],2),
							);
							//print_r($data);
							$this->cart->update_price($data);
							break;
						default:
							if(!$this->config->item('blackfriday')) {
								if( in_array($produs['furnizor_id'], $this->furnizori_asociati) or !($this->session->userdata('discount')>0)){
									if($produs['pret_intreg']<=$produs['pret_vanzare']){
										$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $item['id']));
										if(count($art_gr))
										{
											$prod_gr = $this->magazin_db->articole_grup(array('grup_id' => $art_gr['grup_id']));
											$total_cantitate = 0;
											$produse = array();
											foreach ($prod_gr as $key => $pg) {
												$produse[] = $this->magazin_db->produs(array('id' => $pg['articol_id']));
												$cart_item = $this->cart->find_by_id($pg['articol_id']);
												if($cart_item)
												{
													$produsInGrup = $this->magazin_db->produs(array('id' => $pg['articol_id']));
													$total_cantitate+=($cart_item['qty']/$produsInGrup['cantitate']);
												}
											}
											//calculez reducerea
											$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$total_cantitate));
											$discountVal = 0;
											if(count($discount))
											{
												$discountVal = $discount['discount'];
											}
											foreach ($produse as $p) {
												$cart_item = $this->cart->find_by_id($p['id']);
												if($cart_item)
												{
													$price = round(round($p['pret_vanzare']/$this->content['curs'],2)-round($p['pret_vanzare']/$this->content['curs'],2)*$discountVal/100,2);
													$data = array(
														'rowid' => $cart_item['rowid'],
														'price'	=> $price
													);
													//print_r($data);
													$this->cart->update_price($data);
												}
											}
										} elseif(count($plafon = reduceriProdus($produs['id']))){
											//reducere individuala
											$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $produs['id'], 'no_produse <= '=>$qty/$produs['cantitate']));
											$discountVal = 0;
											if(count($discount))
												$discountVal = $discount['discount'];
											$cart_item = $this->cart->find_by_id($produs['id']);
											if($cart_item)
											{
												$price = round(round($produs['pret_vanzare']/$this->content['curs'],2)-(round($produs['pret_vanzare']/$this->content['curs'],2)*$discountVal)/100,2);
												$data = array(
													'rowid' => $cart_item['rowid'],
													'price'	=> $price
												);
												//print_r($data);
												$this->cart->update_price($data);
												$preturi_noi[$produs['id']] = number_format($price,2,",",".")." ".$this->content['moneda'];
											}
											$result['preturi_noi'] =  $preturi_noi;
										} else{
											//reducere generala
											$preturi_noi = array();
											$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$qty/$produs['cantitate']));
											$discountVal = 0;
											if(count($discount))
												$discountVal = $discount['discount'];
											$cart_item = $this->cart->find_by_id($produs['id']);
											if($cart_item)
											{
												$price = round(round($produs['pret_vanzare']/$this->content['curs'],2)-(round($produs['pret_vanzare']/$this->content['curs'],2)*$discountVal)/100,2);
												$data = array(
													'rowid' => $cart_item['rowid'],
													'price'	=> $price
												);
												//print_r($data);
												$this->cart->update_price($data);
												$preturi_noi[$produs['id']] = number_format($price,2,",",".")." ".$this->content['moneda'];
											}
											$result['preturi_noi'] =  $preturi_noi;
										}
									}
								} // tert cu discount
							} // -- blackfriday
							break;
					}
				}
			}
			$this->produse_cadou();
			$cart = $this->cart->contents();
			$cos = array();
			foreach($cart as $k=>$c){
				$produs = $this->magazin_db->produs(array('id' => $c['id']));
				if(count($produs)){
					$produs['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $produs['id']), array('ordine' => 'asc'));
					$cos[$k] = $c;
					$cos[$k]['url'] = produs_url($produs);
					$cos[$k]['produs'] = $produs;
					$cos[$k]['tva'] = $this->session->userdata('valoare_tva')==0?$this->session->userdata('valoare_tva'):$produs['tva'];
				}
			}
			$this->transport();
			if(!count($cos)){
				$this->sterge_voucher();
				$this->sterge_transport();
				$this->sterge_discount();
			}
			$this->content['cos'] = $cos;
			$this->content['voucher'] = $this->voucher();
			$this->content['transport'] = $this->transport();
			$this->content['discount'] = $this->discount();
			$this->content['discount_produs_cadou'] = $this->discount_produs_cadou();
			$this->content['cos_transport'] = $this->cos_transport;
			
			
			$this->content['error'] = $this->session->flashdata('error');
			$result['msg'] = $this->load->view('cos/cos_continut', $this->content, true);
			$this->utilizator_db->actualizeaza_utilizator($this->session->userdata('id'), array('cos' => serialize($this->cart->contents())));
		}
		else
		{
			$result['qty'] = $item['qty'];
			$result['msg'] = lang('se_mai_poate_comanda_multiplu').$produs['cantitate'].' '.$produs['um'];
		}
		echo json_encode($result);
	}
	function adauga()
	{
		//print_r($this->cart->contents());
		$id = $this->input->post('id');
		$cantitate = $this->input->post('cantitate');
		$produs = $this->magazin_db->produs(array('id' => $id));
		$result['res'] = 'error';
		
		if(count($produs))
		{
			if($cantitate%$produs['cantitate']==0)
			{
				
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
				$cart_item = $this->cart->find_by_id($produs['id']);
				if($cart_item)
				{
					$data_update = array(
						'rowid' => $cart_item['rowid'],
						'qty'	=> 0
						);
					$this->cart->update($data_update);
				}
				$data = array(
					'id'      => $id,
					'qty'     => $cantitate,
					'price'   => round($produs['pret_vanzare']/$this->content['curs'],2),
					'name'    => trim(preg_replace('/\s\s+/', ' ', strip_tags(
									//$produs['denumire']
									$produs['denumire'.$this->session->userdata('fieldLang')]!=''?$produs['denumire'.$this->session->userdata('fieldLang')]:$produs['denumire']
								))),
					'options' => array('cod' => $produs['cod'], 'ecotaxa' => round($produs['ecotaxa']/$this->content['curs'],2), 'furnizor_id' => $produs['furnizor_id'])
				);
				$this->cart->insert($data);
				$result['res'] = 'ok';
				$result['msg'] = '';
				$result['preturi_noi'] = array();
				
				$plafoane_reducere = $this->magazin_db->plafoane_reducere_generale();
				$pret_special = $this->magazin_db->pret_special(array('articol_id' => $produs['id'], 'tert_id' => $this->session->userdata('tert_id')));
				if(count($pret_special)){
					$cart_item = $this->cart->find_by_id($produs['id']);
					if($cart_item){
						$produs = pret_produs($produs, $plafoane_reducere, true);
						$data = array(
							'rowid' => $cart_item['rowid'],
							'price'   => round($produs['pret_vanzare']/$this->content['curs'],2),
						);
						//print_r($data);
						$this->cart->update_price($data);
					}
				} else {
					if($this->session->userdata('discount')==-1){
						switch($this->session->userdata('tip_pret')){
							case 2:
							case 3:
							case 4:
								$cart_item = $this->cart->find_by_id($produs['id']);
								if($cart_item)
								{
									$produs = pret_produs($produs, $plafoane_reducere);
									$data = array(
										'rowid' => $cart_item['rowid'],
										'price'   => round($produs['pret_vanzare']/$this->content['curs'],2),
									);
									//print_r($data);
									$this->cart->update_price($data);
								}
								break;
							default:
								if( in_array($produs['furnizor_id'], $this->furnizori_asociati) or !($this->session->userdata('discount')>0)){
									$maxDiscount = 0;
									if($this->config->item('blackfriday')) {
										if($produs['pret_intreg']<=$produs['pret_vanzare']) 
										{
											$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $id));
											if(count($art_gr))
											{
												$produs['discount'] =  $this->magazin_db->dicounturi_grup(array('grup_id' => produsInGrup($id)));
												foreach ($produs['discount'] as $d) {
													if($maxDiscount < $d['discount'])
														$maxDiscount = $d['discount'];
												}
											} elseif(count($plafon = reduceriProdus($id))) {
												$produs['discount'] = $plafon;
												foreach ($produs['discount'] as $d) {
													if($maxDiscount < $d['discount'])
														$maxDiscount = $d['discount'];
												}
											} else{
												//reduceri generale
												$produs['discount'] = $plafoane_reducere;
												foreach ($produs['discount'] as $d) {
													if($maxDiscount < $d['discount'])
														$maxDiscount = $d['discount'];
												}
											}							
										}
										$cart_item = $this->cart->find_by_id($produs['id']);
										if($cart_item)
										{
											$price = round(round($produs['pret_vanzare']/$this->content['curs'],2)-(round($produs['pret_vanzare']/$this->content['curs'],2)*$maxDiscount)/100,2);
											$data = array(
												'rowid' => $cart_item['rowid'],
												'price'	=> $price
											);
											$this->cart->update_price($data);
										}
									} else {
										if($produs['pret_intreg']<=$produs['pret_vanzare']) 
										{
											$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $id));
											if(count($art_gr))
											{
												//produs in grup
												$prod_gr = $this->magazin_db->articole_grup(array('grup_id' => $art_gr['grup_id'])); //produse din acelasi grup
												$total_cantitate = 0;
												$produse = array();
												foreach ($prod_gr as $key => $pg) {
													$prod_in_grup = $this->magazin_db->produs(array('id' => $pg['articol_id']));
													if(count($prod_in_grup) and ($prod_in_grup['activ'] == 1))
													{
														$produse[] = $prod_in_grup;
													}
													$cart_item = $this->cart->find_by_id($pg['articol_id']);
													if($cart_item)
													{
														//$produsInGrup = $this->magazin_db->produs(array('id' => $pg['articol_id']));
														$total_cantitate+=($cart_item['qty']/$prod_in_grup['cantitate']);
													}
												}
												//calculez reducerea
												$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$total_cantitate));
												$discountVal = 0;
												if(count($discount))
												{
													$discountVal = $discount['discount'];
												}
												$preturi_noi = array();
												if(count($produse))
												{
													foreach($produse as $k=>$p)
													{
														$produse[$k]['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $p['id']), array('ordine' => 'asc'));
														$produse[$k]['pret_vanzare'] = $p['pret_vanzare'];
														$produse[$k]['discountVal'] = $discountVal;
						
														//$stocuri = $this->magazin_db->produs_locatii(array('articol_id' => $p['id']));
														//$stoc = 0;
														//foreach ($stocuri as $s) {
														//	$stoc+=$s['stoc'];
														//}
														//$produse[$k]['stoc'] = $stoc;
														//$p['stoc'] = $stoc;
						
														$price = round(round($p['pret_vanzare']/$this->content['curs'],2)-(round($p['pret_vanzare']/$this->content['curs'],2)*$discountVal)/100,2);
														
														$cart_item = $this->cart->find_by_id($p['id']);
														if($cart_item)
														{
															$data = array(
																'rowid' => $cart_item['rowid'],
																'price'	=> $price
															);
															//print_r($data);
															$this->cart->update_price($data);
														}
														
														if(($p['stoc']!=0) or ($p['stoc_furnizor']!=0))
															$preturi_noi[$p['id']] = number_format($price,2,",",".")." ".$this->content['moneda'];
															else $preturi_noi[$p['id']] = '';
													}
													$cont['produse'] = $produse;
													$cont['total_cantitate'] = $total_cantitate;
													$cont['discount'] = $this->magazin_db->dicounturi_grup(array('grup_id' => $art_gr['grup_id']));
													$cont['moneda'] = $this->content['moneda'];
													$cont['curs'] = $this->content['curs'];
													$result['msg'] = $this->load->view('cos/produse_grup', $cont, true);
												}
												$result['preturi_noi'] =  $preturi_noi;
											}  elseif (count($plafon = reduceriProdus($produs['id']))){
												//reducere individuala
												$discount = $this->magazin_db->plafoan_reducere_individual(array('articol_id' => $produs['id'], 'no_produse <= '=>$cantitate/$produs['cantitate']));
												$discountVal = 0;
												if(count($discount))
													$discountVal = $discount['discount'];
												$cart_item = $this->cart->find_by_id($produs['id']);
												if($cart_item)
												{
													$price = round(round($produs['pret_vanzare']/$this->content['curs'],2)-(round($produs['pret_vanzare']/$this->content['curs'],2)*$discountVal)/100,2);
													$data = array(
														'rowid' => $cart_item['rowid'],
														'price'	=> $price
													);
													//print_r($data);
													$this->cart->update_price($data);
													$preturi_noi[$produs['id']] = number_format($price,2,",",".")." ".$this->content['moneda'];
												}
												$result['preturi_noi'] =  $preturi_noi;
											} else {
												//reducere generala
												$discount = $this->magazin_db->plafoan_reducere_general(array('no_produse <= '=>$cantitate/$produs['cantitate']));
												$discountVal = 0;
												if(count($discount))
													$discountVal = $discount['discount'];
												$cart_item = $this->cart->find_by_id($produs['id']);
												if($cart_item)
												{
													$price = round(round($produs['pret_vanzare']/$this->content['curs'],2)-(round($produs['pret_vanzare']/$this->content['curs'],2)*$discountVal)/100,2);
													$data = array(
														'rowid' => $cart_item['rowid'],
														'price'	=> $price
													);
													//print_r($data);
													$this->cart->update_price($data);
													$preturi_noi[$produs['id']] = number_format($price,2,",",".")." ".$this->content['moneda'];
												}
												$result['preturi_noi'] =  $preturi_noi;
											}	
										}
									}
								}
								break;
						}
					} else {
						$this->discount();
					}
				}
				$this->transport();
				$this->utilizator_db->actualizeaza_utilizator($this->session->userdata('id'), array('cos' => serialize($this->cart->contents())));
				$this->produse_cadou();
			}
			else
			{
				$result['msg'] = lang('se_poate_comanda_numai_multiplu').$produs['cantitate'].' '.$produs['um'];
			}
		}
		else
		{
			$result['msg'] = lang('produsul_nu_a_fost_gasit');
		}
		echo json_encode($result);
	}
	function produse_cadou(){
		if($this->cart->total_fara_transport() >= $this->config->item('suma_produse_cadou')){
			if(count($this->config->item('produse_cadou'))){
				$discount = 0;
				foreach($this->config->item('produse_cadou') as $pcod){
					$produs = $this->magazin_db->produs(array('cod' => $pcod));
					if(count($produs)){
						$cantitate = $produs['cantitate']<=0?1:$produs['cantitate'];
						$data = array(
							'id'      => $produs['id'],
							'qty'     => $cantitate,
							'price'   => round($produs['pret_vanzare']/$this->content['curs'],2),
							'name'    => trim(preg_replace('/\s\s+/', ' ', strip_tags(
											//$produs['denumire']
											$produs['denumire'.$this->session->userdata('fieldLang')]!=''?$produs['denumire'.$this->session->userdata('fieldLang')]:$produs['denumire']
										))),
							'options' => array('cod' => $produs['cod'], 'ecotaxa' => round($produs['ecotaxa']/$this->content['curs'],2), 'furnizor_id' => $produs['furnizor_id'], 'tip' => 'produs_cadou')
						);
						$discount+= $cantitate*round($produs['pret_vanzare']/$this->content['curs'],2);
						$this->cart->insert($data);
					}
				}
				if($discount!=0){
					$data = array(
						'id'      => 'discount_produse_cadou',
						'qty'     => -1,
						'price'   => $discount,
						'name'    => 'Discount',
						'options' => array(
								'info' 	=> 'discount',
								'cod'	=> '709'
							)
						);
					$this->cart->insert($data);
				}
			}
		} else {
			foreach($this->cart->contents() as $c){
				$optiuni = $c['options'];
				//print_r($optiuni);
				if(isset($optiuni['tip']) and ($optiuni['tip'] == 'produs_cadou')){
					$data_update = array(
						'rowid' => $c['rowid'],
						'qty'	=> 0
						);
					$this->cart->update($data_update);
				}
			}
			$discount = $this->cart->find_by_id('discount_produse_cadou');
			$data_update = array(
				'rowid' => $discount['rowid'],
				'qty'	=> 0
				);
			$this->cart->update($data_update);
		}
	}
	function actualizeaza_vizualizare()
	{
		$res['no_articole'] = count($this->cart->contents());
		$item = $this->cart->find_by_id('transport');
		if(count($item)){
			$res['no_articole'] -=1;
		}
		$item = $this->cart->find_by_id('discount');
		if(count($item)){
			$res['no_articole'] -=1;
		}
		$res['no_suma'] = number_format($this->cart->total(),2,",",".").' RON';
		echo json_encode($res);
	}
	function cos_top()
	{
		$no_articole = count($this->cart->contents());
		$item = $this->cart->find_by_id('transport');
		if(count($item)){
			$no_articole -=1;
		}
		$item = $this->cart->find_by_id('discount');
		if(count($item)){
			$no_articole -=1;
		} 
		$ret = array(
				'list' 			=> $this->load->view('cos/cos_top_list', $this->content, TRUE), 
				'sumar' 		=> $this->load->view('cos/cos_top_sumar', $this->content, TRUE),
				'no_articole'	=> $no_articole
			);

		echo json_encode($ret);
	}
	function sterge_produs(){
		$id = $this->input->post('id');
		$items = $this->cart->contents();
		$item = $items[$id];
		//$produs = $this->magazin_db->produs(array('id' => $item['id']));

		$data = array(
			'rowid' => $id,
			'qty'   => 0
		);
		$this->cart->update($data);
		if(!$this->config->item('blackfriday')) {
			$art_gr = $this->magazin_db->articol_grup(array('articol_id' => $item['id']));
			if(count($art_gr))
			{
				$prod_gr = $this->magazin_db->articole_grup(array('grup_id' => $art_gr['grup_id']));
				$total_cantitate = 0;
				$produse = array();
				foreach ($prod_gr as $key => $pg) {
					$produse[] = $this->magazin_db->produs(array('id' => $pg['articol_id']));
					$cart_item = $this->cart->find_by_id($pg['articol_id']);
					if($cart_item)
						$total_cantitate+=$cart_item['qty'];
				}
				//calculez reducerea
				$discount = $this->magazin_db->discount_grup(array('grup_id' => $art_gr['grup_id'], 'no_produse <= '=>$total_cantitate));
				$discountVal = 0;
				if(count($discount))
				{
					$discountVal = $discount['discount'];
				}
				foreach ($produse as $_produs) {
					if(isset($_produs['id'])){
						$cart_item = $this->cart->find_by_id($_produs['id']);
						if($cart_item)
						{
							$pret_vanzare = round($_produs['pret_vanzare']/$this->content['curs'],2);
							$price = $pret_vanzare-$pret_vanzare*$discountVal/100;
							$data = array(
								'rowid' => $cart_item['rowid'],
								'price'	=> $price
							);
							//print_r($data);
							$this->cart->update_price($data);
						}
					}
				}
			}
		}
		$this->produse_cadou();
		$cart = $this->cart->contents();
		$cos = array();
		foreach($cart as $k=>$c){
			$produs = $this->magazin_db->produs(array('id' => $c['id']));
			if(count($produs)){
				$produs['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $produs['id']), array('ordine' => 'asc'));
				$cos[$k] = $c;
				$cos[$k]['url'] = produs_url($produs);
				$cos[$k]['produs'] = $produs;
				$cos[$k]['tva'] = $this->session->userdata('valoare_tva')==0?0:$produs['tva'];
			}
		}
		if(!count($cos)){
			$this->sterge_voucher();
			$this->sterge_transport();
			$this->sterge_discount();
		}
		$this->transport();
		$this->utilizator_db->actualizeaza_utilizator($this->session->userdata('id'), array('cos' => serialize($this->cart->contents())));
		$this->content['cos'] = $cos;
		$this->content['voucher'] = $this->voucher();
		$this->content['transport'] = $this->transport();
		$this->content['discount'] = $this->discount();
		$this->content['discount_produs_cadou'] = $this->discount_produs_cadou();
		$this->content['cos_transport'] = $this->cos_transport;
		$this->content['error'] = $this->session->flashdata('error');
		$result['msg'] = $this->load->view('cos/cos_continut', $this->content, true);
		echo json_encode($result);
	}
	function finalizare_comanda()
	{
		check_logged();
		$cos = $this->cart->contents();
		if(!count($cos)){redirect(site_url()); exit();}
		$valoare_tva = $this->session->userdata('valoare_tva');
		if((string)$valoare_tva == ''){
			$valoare_tva = $this->companie_tva;
		}
		$total = 0;
		foreach($cos as $k=>$c){
			$produs = $this->magazin_db->produs(array('id' => $c['id']));
			if(count($produs)){
				if(isset($c['options']['info']) and ($c['options']['info'] == 'voucher')){
					$produs['tva'] = $valoare_tva;
					$voucher = $c['options']['cod'];
				} else {
					$produs['tva'] = $this->session->userdata('valoare_tva')==0?$this->session->userdata('valoare_tva'):$produs['tva'];
				}
				$total+=$c['subtotal']*(100+$produs['tva'])/100;
			}
		}
		$voucher = $this->cart->find_by_id('voucher');
		if($voucher){
			$total+=$voucher['subtotal']*(100+$valoare_tva)/100;
		}
		$transport = $this->cart->find_by_id('transport');
		if($transport){
			$total+=$transport['subtotal']*(100+$valoare_tva)/100;
		}
		$discount = $this->cart->find_by_id('discount');
		if($discount){
			$total+=$discount['subtotal']*(100+$valoare_tva)/100;
		}
		$discount_produse_cadou = $this->cart->find_by_id('discount_produse_cadou');
		if($discount_produse_cadou){
			$produs_id = $this->cart->find_by_options('tip', 'produs_cadou');
			$produs = $this->magazin_db->produs(array('id' => $produs_id));
			$produs['tva'] = $this->session->userdata('valoare_tva')==0?$this->session->userdata('valoare_tva'):$produs['tva'];
			$total+=$discount_produse_cadou['subtotal']*(100+$produs['tva'])/100;
		}
		$cos['total'] = $total;
		$this->load->library('form_validation');
		if($this->input->post('dropshipping')!=1){
			$this->form_validation->set_rules('adresa_id', lang('adresa_livrare'), 'trim|required');
		}
		$this->form_validation->set_rules('nota', lang('nota'), 'trim');
		$this->form_validation->set_rules('dropshipping', 'Dropshipping', 'trim');
		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() == FALSE)
		{
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			
			$adr = $this->utilizator_db->adrese_livrare(array('tert_id' => $this->session->userdata('tert_id')));
			$judete = $this->config->item('judet');
			$tara = $this->config->item('tara');
			$adrese[''] = '';
			foreach($adr as $al){
				if($al['tara']=='RO'){
					$adrese[$al['id']] = $tara[$al['tara']].', '.$judete[$al['judet']].', '.$al['oras'].', '.$al['adresa'];
				} else {
					$adrese[$al['id']] = $adrese[$al['id']] = $tara[$al['tara']].', '.$al['judet'].', '.$al['oras'].', '.$al['adresa'];
				}
			}
			$this->content['utilizator'] = $this->utilizator_db->tert(array('id' => $this->session->userdata('tert_id')));
			$this->content['judete'] = $judete;
			$this->content['tara'] = $tara;
			$this->content['adrese_livrare'] = $adrese;
			
			$this->content['cos'] = $cos;
			$this->content['termeni'] = $this->continut_db->pagina(array('id' => 1));
			
			$this->layout['content'] = $this->load->view('cos/finalizare_comanda', $this->content, true);
			$this->load->view('layout', $this->layout);
		} else {
			$comenzi_generate[0] = false;
			$total_comenzi[0] = 0;
			foreach ($this->furnizori_asociati as $key => $id) {
				$comenzi_generate[$id] = false;
				$total_comenzi[$id] = 0;
			}
			$this->load->model(array('comenzi_db', 'companii_db'));
			//adauga comanda
			$tert = $this->utilizator_db->tert(array('id' => $this->session->userdata('tert_id')));
			$magazin_companie = $this->companii_db->magazin_companie(array('magazin' => $tert['magazin']));
			$companie_id = 1;
			if(count($magazin_companie)){
				$companie_id = $magazin_companie['companie_id'];
			}
			switch($tert['modplata_id'])
			{
				case '0': //Avans
				case '1': //Cash
					$termenplata = 7;
					break;
				default:
					$termenplata = $tert['termenplata'];
					break;
			}
			$moneda = $this->content['moneda'];
			
			$adresa_id = $this->input->post('adresa_id');
			if($this->input->post('dropshipping')==1){
				$adresa_livrare = $this->utilizator_db->adresa_livrare(array('tert_id' => $this->session->userdata('tert_id')));
				$adresa_id = $adresa_livrare['id'];
			}
			if($this->input->post('dropshipping')!=1){
				$this->_adauga_transport();
				$adresa_livrare = $this->utilizator_db->adresa_livrare(array('id' => $adresa_id));
				$adauga_catalog = 0;
				if($this->config->item('adauga_catalog')==1){
					if($adresa_livrare['catalog'] == 0){
						$produs = $this->magazin_db->produs(array('cod' => '623.01'));
						if(count($produs)){
							$adauga_catalog = 1;
							$data_cos = array(
								'id'      => $produs['id'],
								'qty'     => 1,
								'price'   => 0,
								'name'    => trim(preg_replace('/\s\s+/', ' ', strip_tags(
									//$produs['denumire']
									$produs['denumire'.$this->session->userdata('fieldLang')]!=''?$produs['denumire'.$this->session->userdata('fieldLang')]:$produs['denumire']
								)))
							);
							$this->cart->insert($data_cos);
						}
					}
				}
			}
			$cos = $this->cart->contents();
			$voucher = $this->cart->find_by_id('voucher');
			$transport = $this->cart->find_by_id('transport');
			$discount = $this->cart->find_by_id('discount');
			$discount_produse_cadou = $this->cart->find_by_id('discount_produse_cadou');
			$_produs_id = $this->cart->find_by_options('tip', 'produs_cadou');
			$this->utilizator_db->actualizeaza_utilizator($this->session->userdata('id'), array('cos' => ''));
			if($this->input->post('dropshipping')!=1){
				if($this->config->item('adauga_catalog')==1){
					$this->utilizator_db->actualizeaza_adresa_livrare($this->input->post('adresa_id'), array('catalog' => 1));
				}
			} else {
				$this->sterge_transport();
				$transport = $this->cart->find_by_id('transport');
				$cos = $this->cart->contents();
			}
			$this->cart->destroy();
			
			foreach($cos as $k=>$c){
				$produs = $this->magazin_db->produs(array('id' => $c['id']));
				if(count($produs)){
					if(!(isset($c['options']['info']) and ($c['options']['info']=='voucher'))){
						if(in_array($produs['furnizor_id'], $this->furnizori_asociati)){ // in functie de id_furnizor pentru produs creez una sau mai multe comenzi
							$furnizor_id = $produs['furnizor_id'];
						} else {
							$furnizor_id = 0;
						}
						if(!$comenzi_generate[$furnizor_id]){
							$rec_comanda = array(
								'tert_id'				=> $this->session->userdata('tert_id'),
								'tert_utilizator_id'	=> $this->session->userdata('id'),
								'companie_id'			=> $companie_id,
								'adresa_id'				=> $adresa_id,
								'dropshipping'			=> $this->input->post('dropshipping')==1?1:0,
								'data'					=> date('Y-m-d H:i:s'),
								'stare'					=> 1,
								'observatii'			=> $this->input->post('nota'),
								'nota'					=> $this->input->post('dropshipping')==1?$this->input->post('nota'):'',
								'modplata_id'			=> $tert['modplata_id'],
								'termenplata'			=> $termenplata,
								'moneda'				=> $moneda,
								'valoare_tva'			=> $valoare_tva
							);
							// print_r($rec_comanda);
							// exit();
							$id_comanda = $this->comenzi_db->adauga($rec_comanda);
							$comenzi_generate[$furnizor_id] = $id_comanda;
							insertLog(array(
								'utilizator_id' => 0, 
								'actiune'       => 'Adauga comanda din magazin: '.$id_comanda,
								'tip'			=> 'comanda',
								'tip_id'		=> $id_comanda,
								'operatii'		=> serialize($rec_comanda),
								));
						}
						$comanda_id = $comenzi_generate[$furnizor_id];
						$cos[$k]['url'] = produs_url($produs);
						$produs['tva'] = $this->session->userdata('valoare_tva')==0?$this->session->userdata('valoare_tva'):$produs['tva'];
						$rec_art = array(
							'comanda_id'	=> $comanda_id,
							'articol_id'	=> $produs['id'],
							'cod'			=> $produs['cod'],
							'articol'		=> $produs['denumire'.$this->session->userdata('fieldLang')]!=''?$produs['denumire'.$this->session->userdata('fieldLang')]:$produs['denumire'],
							'um'			=> $produs['um'],
							'tva'			=> $produs['tva'],
							'cantitate'		=> $c['qty'],
							'pret_vanzare'	=> $c['price'],
							'valoare'		=> $c['qty']*$c['price'],
							'total'			=> round($c['qty']*$c['price']*(100+$produs['tva'])/100,2),
						);
						$this->comenzi_db->adauga_linie($rec_art);
						$total_comenzi[$furnizor_id]+=round($c['subtotal']*(100+$produs['tva'])/100,2);
					}
				}
			}
			
			if($voucher){
				if(!$comenzi_generate[0]){
					$rec_comanda = array(
						'tert_id'				=> $this->session->userdata('tert_id'),
						'tert_utilizator_id'	=> $this->session->userdata('id'),
						'adresa_id'				=> $adresa_id,
						'dropshipping'			=> $this->input->post('dropshipping')==1?1:0,
						'data'					=> date('Y-m-d H:i:s'),
						'stare'					=> 1,
						'observatii'			=> $this->input->post('nota'),
						'nota'					=> $this->input->post('dropshipping')==1?$this->input->post('nota'):'',
						'modplata_id'			=> $tert['modplata_id'],
						'termenplata'			=> $termenplata,
						'moneda'				=> $moneda,
						'valoare_tva'			=> $valoare_tva
					);
					// print_r($rec_comanda);
					// exit();
					$comenzi_generate[0] = $this->comenzi_db->adauga($rec_comanda);
				}
				$cod = $voucher['options']['cod'];
				$v = $this->magazin_db->voucher(array('cod' => $cod));
				$produs = $this->magazin_db->produs(array('cod' => 709));
				if(isset($produs['id']))
					$id_prod = $produs['id'];
					else $id_prod = 0;
				$rec_art = array(
					'comanda_id'	=> $comenzi_generate[0],
					'articol_id'	=> $id_prod,
					'cod'			=> 709,
					'articol'		=> $voucher['name'],
					'um'			=> 'buc',
					'tva'			=> $this->companie_tva,
					'cantitate'		=> $voucher['qty'],
					'pret_vanzare'	=> $voucher['price'],
					'valoare'		=> $voucher['qty']*$voucher['price'],
					'total'			=> $voucher['qty']*$voucher['price']*(100+$valoare_tva)/100,
				);
				$this->comenzi_db->adauga_linie($rec_art);
				$total_comenzi[0]+=$voucher['subtotal']*(100+$this->companie_tva)/100;
				$this->magazin_db->adauga_voucher_utilizat(array(
					'voucher_id'	=> $v['id'], 
					'utilizator_id'	=> $this->session->userdata('id'),
					'comanda_id'	=> $comenzi_generate[0],
					'data' 			=> date('Y-m-d H:i:s')

				));
				// $this->magazin_db->actualizeaza_voucher($v['id'], array('stare' => 2, 'data_utilizare' => date('Y-m-d')));
			}
			
			if($transport){
				if(!$comenzi_generate[0]){
					$rec_comanda = array(
						'tert_id'				=> $this->session->userdata('tert_id'),
						'tert_utilizator_id'	=> $this->session->userdata('id'),
						'adresa_id'				=> $adresa_id,
						'dropshipping'			=> $this->input->post('dropshipping')==1?1:0,
						'data'					=> date('Y-m-d H:i:s'),
						'stare'					=> 1,
						'observatii'			=> $this->input->post('nota'),
						'nota'					=> $this->input->post('dropshipping')==1?$this->input->post('nota'):'',
						'modplata_id'			=> $tert['modplata_id'],
						'termenplata'			=> $termenplata,
						'moneda'				=> $moneda,
						'valoare_tva'			=> $valoare_tva
					);
					// print_r($rec_comanda);
					// exit();
					$comenzi_generate[0] = $this->comenzi_db->adauga($rec_comanda);
				}
				$cod = $transport['options']['cod'];
				$produs = $this->magazin_db->produs(array('cod' => $cod));
				if(isset($produs['id']))
					$id_prod = $produs['id'];
					else $id_prod = 0;
				$rec_art = array(
					'comanda_id'	=> $comenzi_generate[0],
					'articol_id'	=> $id_prod,
					'cod'			=> $cod,
					'articol'		=> $transport['name'],
					'um'			=> 'buc',
					'tva'			=> $this->companie_tva,
					'cantitate'		=> $transport['qty'],
					'pret_vanzare'	=> $transport['price'],
					'valoare'		=> $transport['qty']*$transport['price'],
					'total'			=> $transport['qty']*$transport['price']*(100+$valoare_tva)/100,
				);
				$this->comenzi_db->adauga_linie($rec_art);
				$total_comenzi[0]+=$transport['subtotal']*(100+$this->companie_tva)/100;
			}
			
			if($discount){
				if(!$comenzi_generate[0]){
					$rec_comanda = array(
						'tert_id'				=> $this->session->userdata('tert_id'),
						'tert_utilizator_id'	=> $this->session->userdata('id'),
						'adresa_id'				=> $adresa_id,
						'dropshipping'			=> $this->input->post('dropshipping')==1?1:0,
						'data'					=> date('Y-m-d H:i:s'),
						'stare'					=> 1,
						'observatii'			=> $this->input->post('nota'),
						'nota'					=> $this->input->post('dropshipping')==1?$this->input->post('nota'):'',
						'modplata_id'			=> $tert['modplata_id'],
						'termenplata'			=> $termenplata,
						'moneda'				=> $moneda,
						'valoare_tva'			=> $valoare_tva
					);
					// print_r($rec_comanda);
					// exit();
					$comenzi_generate[0] = $this->comenzi_db->adauga($rec_comanda);
				}
				$cod = $discount['options']['cod'];
				$produs = $this->magazin_db->produs(array('cod' => $cod));
				if(isset($produs['id']))
					$id_prod = $produs['id'];
					else $id_prod = 0;
				$rec_art = array(
					'comanda_id'	=> $comenzi_generate[0],
					'articol_id'	=> $id_prod,
					'cod'			=> $cod,
					'articol'		=> $discount['name'],
					'um'			=> 'buc',
					'tva'			=> $this->companie_tva,
					'cantitate'		=> $discount['qty'],
					'pret_vanzare'	=> $discount['price'],
					'valoare'		=> $discount['qty']*$discount['price'],
					'total'			=> $discount['qty']*$discount['price']*(100+$valoare_tva)/100,
				);
				$this->comenzi_db->adauga_linie($rec_art);
				$total_comenzi[0]+=$discount['subtotal']*(100+$this->companie_tva)/100;
			}
			if($discount_produse_cadou){
				if(!$comenzi_generate[0]){
					$rec_comanda = array(
						'tert_id'				=> $this->session->userdata('tert_id'),
						'tert_utilizator_id'	=> $this->session->userdata('id'),
						'adresa_id'				=> $adresa_id,
						'dropshipping'			=> $this->input->post('dropshipping')==1?1:0,
						'data'					=> date('Y-m-d H:i:s'),
						'stare'					=> 1,
						'observatii'			=> $this->input->post('nota'),
						'nota'					=> $this->input->post('dropshipping')==1?$this->input->post('nota'):'',
						'modplata_id'			=> $tert['modplata_id'],
						'termenplata'			=> $termenplata,
						'moneda'				=> $moneda,
						'valoare_tva'			=> $valoare_tva
					);
					// print_r($rec_comanda);
					// exit();
					$comenzi_generate[0] = $this->comenzi_db->adauga($rec_comanda);
				}
				$cod = $discount_produse_cadou['options']['cod'];
				$produs = $this->magazin_db->produs(array('cod' => $cod));
				$_produs_discount = $this->magazin_db->produs(array('id' => $_produs_id));
				if(count($_produs_discount)){
					$_val_tva_pd = $_produs_discount['tva'];
					$id_prod = $_produs_discount['id'];
				} else {
					if(isset($produs['id'])){
						$id_prod = $produs['id'];
						$_val_tva_pd = $produs['tva'];
					} else {
						$id_prod = 0;
						$_val_tva_pd = $valoare_tva;
					}
				}
				$rec_art = array(
					'comanda_id'	=> $comenzi_generate[0],
					'articol_id'	=> $id_prod,
					'cod'			=> $cod,
					'articol'		=> $discount_produse_cadou['name'],
					'um'			=> 'buc',
					'tva'			=> $_val_tva_pd,
					'cantitate'		=> $discount_produse_cadou['qty'],
					'pret_vanzare'	=> $discount_produse_cadou['price'],
					'valoare'		=> $discount_produse_cadou['qty']*$discount_produse_cadou['price'],
					'total'			=> $discount_produse_cadou['qty']*$discount_produse_cadou['price']*(100+$_val_tva_pd)/100,
				);
				$this->comenzi_db->adauga_linie($rec_art);
				$total_comenzi[0]+=$discount_produse_cadou['subtotal']*(100+$_val_tva_pd)/100;
			}
			//adauga un todo
			$utilizator = $this->utilizator_db->tert(array('id' => $this->session->userdata('tert_id')));
			$agent = array();
			if($utilizator['id_agent']!=0){
				//agent asociat direct
				$agent = $this->utilizator_db->agent(array('id' => $utilizator['id_agent']));
			} else {
				if($tert['tara'] == 'RO'){
					$agent_judet = $this->utilizator_db->agent_judet(array('judet' => $utilizator['judet']));
					if(count($agent_judet)){
						//agnet alocat judetului
						$agent = $this->utilizator_db->agent(array('id' => $agent_judet['user_id']));
					}
				} else {
					$agent = $this->utilizator_db->agent(array('id' => 16));
				}
			}
			foreach($comenzi_generate as $furnizor_id => $comanda_id){
				if($comanda_id){
					if($this->input->post('dropshipping')==1){

						if(isset($_FILES['fisier_factura']) and ($_FILES['fisier_factura']['name'])){
							$config_upload['upload_path'] = $this->config->item('media_path').'terti/';
							$config_upload['allowed_types'] = '*';
							$this->load->library('upload', $config_upload);
							if ( $this->upload->do_upload('fisier_factura'))
							{
								$file_arr = $this->upload->data();
								$this->comenzi_db->actualizeaza($comanda_id, array('fisier_factura' => $file_arr['file_name']));
								$redirect = true;
							} else{
								echo $this->upload->display_errors();exit();
							}
						}
						if(isset($_FILES['fisier_awb']) and ($_FILES['fisier_awb']['name'])){
							$config_upload['upload_path'] = $this->config->item('media_path').'terti/';
							$config_upload['allowed_types'] = '*';
							$this->load->library('upload', $config_upload);
							if ( $this->upload->do_upload('fisier_awb'))
							{
								$file_arr = $this->upload->data();
								$this->comenzi_db->actualizeaza($comanda_id, array('fisier_awb' => $file_arr['file_name']));
							}
						}
					}
					$this->comenzi_db->actualizeaza($comanda_id, array('total' => $total_comenzi[$furnizor_id]));
					$rec_todo = array(
						'user_id'		=> $agent['id'],
						'tert_id'		=> $this->session->userdata('tert_id'),
						'tip_id'		=> 2,
						'tip_info'		=> $comanda_id,
						'comanda_id'	=> $comanda_id,
						'data'			=> date('Y-m-d H:i:s'),
						'stare'			=> 0,
						'prioritate'	=> 2,
						'descriere'		=> 'Comanda nou'
						);
					$task_id = $this->magazin_db->adauga_to($rec_todo);
					//$rec = array(
					//	'todo_id'		=> $task_id,
					//	'tert_id'		=> $this->session->userdata('tert_id'),
					//	'data'			=> date('Y-m-d H:i:s'),
					//	'observatie'	=> $this->input->post('nota'),
					//	'user_id'		=> 0
					//	);
					//$this->magazin_db->adauga_to_obs($rec);
					copiere_comanda($comanda_id);
					//trimitere email comanda
					$this->email_utilizator($comanda_id);
					$this->email_magazin($comanda_id);
				}
			}
			redirect('utilizator/comenzi');
		}
	}
	function sterge_cos(){
		$this->cart->destroy();
		$this->utilizator_db->actualizeaza_utilizator($this->session->userdata('id'), array('cos' => serialize($this->cart->contents())));
		redirect(site_url());
	}
	function email_utilizator($id){
		$this->load->model('comenzi_db');
		$where = array(
			'id'		=> $id
		);
		$comanda = $this->comenzi_db->comanda($where);
		$continut = $this->comenzi_db->continut(array('comanda_id' => $comanda['id']));
		foreach($continut as $k=>$c){
			$produs = $this->magazin_db->produs(array('id' => $c['articol_id']));
			$continut[$k]['produs'] = $produs;
			//$continut[$k]['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $produs['id']), array('ordine' => 'asc'));;
		}
		$tert = $this->utilizator_db->tert(array('id' => $comanda['tert_id']));
		$utilizator = $this->utilizator_db->utilizator(array('id' => $comanda['tert_utilizator_id']));
		$_email = $tert['email'];
		if(is_array($utilizator) and count($utilizator) and ($utilizator['email']!='')){
			$_email = $utilizator['email'];
		}
		$this->content['tert'] = $tert;
		$this->content['comanda'] = $comanda;
		$this->content['continut'] = $continut;
		$this->content['adresa_livrare'] = $this->utilizator_db->adresa_livrare(array('id' => $comanda['adresa_id']));
		$this->content['judete'] = $this->config->item('judet');

		if($tert['tip']==1)
			$denumire = $tert['denumire'];
			else $denumire = $tert['nume'].' '.$tert['prenume'];

		$mesaj = $this->load->view('cos/email_utilizator', $this->content, true);

		$this->load->library('email');
		$config = Array(
			'protocol'  => 'smtp',
			'smtp_host' => $this->config->item('host_name'),
			'smtp_user' => $this->config->item('user_email'),
			'smtp_pass' => $this->config->item('password_email'),
			'mailtype'  => 'html',
			'newline'   => "\r\n"
		);

		$this->email->initialize($config);
		$this->email->from($this->config->item('from_email'), "Globiz");
		$this->email->reply_to($this->config->item('reply_email'), 'Globiz');
		
		if($_email!='')
		{
			$this->email->to($_email, $denumire);
			$this->email->subject('Comanda: '.$comanda['id']);
			$this->email->message($mesaj);
			$this->email->send();
		}
	}
	function email_magazin($id){
		$this->load->model('comenzi_db');
		$where = array(
			'id'		=> $id
		);
		$comanda = $this->comenzi_db->comanda($where);
		$continut = $this->comenzi_db->continut(array('comanda_id' => $comanda['id']));
		foreach($continut as $k=>$c){
			$produs = $this->magazin_db->produs(array('id' => $c['articol_id']));
			$continut[$k]['produs'] = $produs;
			//$continut[$k]['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $produs['id']), array('ordine' => 'asc'));;
		}
		$tert = $this->utilizator_db->tert(array('id' => $comanda['tert_id']));
		
		$this->content['tert'] = $tert;
		$this->content['comanda'] = $comanda;
		$this->content['continut'] = $continut;
		$this->content['adresa_livrare'] = $this->utilizator_db->adresa_livrare(array('id' => $comanda['adresa_id']));
		$this->content['judete'] = $this->config->item('judet');

		if($tert['tip']==1)
			$denumire = $tert['denumire'];
			else $denumire = $tert['nume'].' '.$tert['prenume'];

		$mesaj = $this->load->view('cos/email_magazin', $this->content, true);

		$this->load->library('email');
		$config = Array(
			'protocol'  => 'smtp',
			'smtp_host' => $this->config->item('host_name'),
			'smtp_user' => $this->config->item('user_email'),
			'smtp_pass' => $this->config->item('password_email'),
			'mailtype'  => 'html',
			'newline'   => "\r\n"
		);

		$this->email->initialize($config);
		if($tert['email']!='')
			$this->email->from($tert['email'], $denumire);
			else $this->email->from($this->config->item('reply_email'), $denumire);
		$this->email->to($this->config->item('from_email'));
		// $this->email->to('luci@solutiiweb.ro');

		$this->email->subject('Comanda: '.$comanda['id']);
		$this->email->message($mesaj);

		$this->email->send();
	}

	function precomanda(){
		$this->load->library('parser');
		$this->load->model('comenzi_db');
		$id = $this->input->post('id');
		$cantitate = $this->input->post('cantitate');
		$produs = $this->magazin_db->produs(array('id' => $id));
		if(count($produs))
		{
			if($cantitate%$produs['cantitate']==0)
			{
				$where = array(
					'tert_id'				=> $this->session->userdata('tert_id'),
					'tert_utilizator_id'	=> $this->session->userdata('id'),
					'produs_id'      		=> $id
					);
				if(count($this->comenzi_db->precomanda($where)))
				{
					$result['msg'] = lang('produsul_precomandat_deja');
				} else {
					$data = array(
						'tert_id'				=> $this->session->userdata('tert_id'),
						'tert_utilizator_id'	=> $this->session->userdata('id'),
						'produs_id'      => $id,
						'cantitate'     => $cantitate,
						'pret'   => round($produs['pret_vanzare'],2),
						'data'	=> date('Y-m-d')
					);
					$this->comenzi_db->adauga_precomanda($data);
					$result['msg'] = lang('produsul').' <b>'.$produs['denumire'].' <i>(cod: '.$produs['cod'].')</i></b> - '.$cantitate.' '.$produs['um'].' - '.lang('ati_optat_pentru_precomanda');
					
					$denumire = '<b>'.$produs['denumire'].' <i>(cod: '.$produs['cod'].')</i></b> - '.$cantitate.' '.$produs['um'];
					$result['msg'] = $this->parser->parse_string(lang('ati_optat_pentru_precomanda'), array('denumire_produs' => $denumire, 'link_precomenzi' => site_url('utilizator/precomenzi')), TRUE);

					//trimite mail precomanda
					/*
					$utilizator = $this->utilizator_db->tert(array('id' => $this->session->userdata('tert_id')));
					$agent = array();
					if($utilizator['id_agent']!=0){
						//agent asociat direct
						$agent = $this->utilizator_db->agent(array('id' => $utilizator['id_agent']));
					} else {
						$agent_judet = $this->utilizator_db->agent_judet(array('judet' => $utilizator['judet']));
						if(count($agent_judet)){
							//agnet alocat judetului
							$agent = $this->utilizator_db->agent(array('id' => $agent_judet['user_id']));
						}
					}
					$mesaj = "Clientul ".$utilizator['denumire']." a precomandat ".$cantitate." buc. din produsul <b>".$produs['denumire']." <i>(cod: ".$produs['cod'].")</i></b> in data de ".date('d/m/Y', strtotime($data['data']));
					

					//$list = array('ldumea@yahoo.com');
					$list = array('janos.budai@carguard.ro');
					if(count($agent)){
						if($agent['email']!=''){
							$list[] = $agent['email'];
						}
					}

					$this->load->library('email');
					$config = Array(
						'protocol'  => 'smtp',
						'smtp_host' => $this->config->item('host_name'),
						'smtp_user' => $this->config->item('user_email'),
						'smtp_pass' => $this->config->item('password_email'),
						'mailtype'  => 'html',
						'newline'   => "\r\n"
					);
					$this->email->initialize($config);
					$this->email->from($this->config->item('from_email'), "Globiz");
					$this->email->reply_to($this->config->item('reply_email'), 'Globiz');
					$this->email->to($list);

					$this->email->subject('Precomanda');
					$this->email->message($mesaj);
					$this->email->send();
					*/
				}
			}
			else
			{
				$result['msg'] = lang('se_mai_poate_comanda_multiplu').' '.$produs['cantitate'].' '.$produs['um'];
			}
		}
		else
		{
			$result['msg'] = lang('produsul_nu_a_fost_gasit');
		}
		echo json_encode($result);
	}
	
	function goleste_cos(){
		foreach($this->cart->contents() as $c){
			$data_update = array(
						'rowid' => $c['rowid'],
						'qty'	=> 0
						);
					$this->cart->update($data_update);
		}
	}
	
	function continut_cos(){
		$cart = $this->cart->contents();
		//print_R($cart);
		//exit();
		$cos = array();
		foreach($cart as $k=>$c){
			$produs = $this->magazin_db->produs(array('id' => $c['id']));
			if(count($produs)){
				$produs['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $produs['id']), array('ordine' => 'asc'));
				$cos[$k] = $c;
				$cos[$k]['url'] = produs_url($produs);
				$cos[$k]['produs'] = $produs;
				$cos[$k]['tva'] = $this->session->userdata('valoare_tva')==0?$this->session->userdata('valoare_tva'):$produs['tva'];
			}
		}

		$this->content['cos'] = $cos;
		$this->content['voucher'] = $this->voucher();
		$this->content['transport'] = $this->transport();
		$this->content['discount'] = $this->discount();
		$this->content['discount_produs_cadou'] = $this->discount_produs_cadou();
		$this->content['cos_transport'] = $this->cos_transport;
		
		$raspuns['cos_continut'] = $this->load->view('cos/cos_continut', $this->content, true);
		$raspuns['list'] = $this->load->view('cos/cos_top_list', $this->content, TRUE);
		$raspuns['sumar'] = $this->load->view('cos/cos_top_sumar', $this->content, TRUE);
		echo json_encode($raspuns);
	}
	function copiaza_original(){
		$this->load->model('comenzi_db');
		$comenzi_originale = $this->comenzi_db->comenzi(array('stare' => 1));
		foreach($comenzi_originale as $c){
			copiere_comanda($c['id']);
		}
	}
}