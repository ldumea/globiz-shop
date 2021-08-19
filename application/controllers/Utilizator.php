<?
class Utilizator extends MY_Controller
{
	var $layout, $content;
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('utilizator_db', 'comenzi_db', 'garantii_db', 'facturi_db', 'curieri_db', 'companii_db'));



		$this->layout['css'][] = site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css');
        $this->layout['css'][] = site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
		
		
		
		
		$this->layout['css'][] = site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.min.css');
		$this->layout['css'][] = site_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
		$this->content['javascript'][] = base_url().'assets/plugins/moment/moment.min.js?v='.$this->config->item('css_js');
		$this->content['javascript'][] = base_url().'assets/plugins/moment/ro.js?v='.$this->config->item('css_js');
        $this->content['javascript'][] = site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js');
		$this->content['javascript'][] = site_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
		$this->content['javascript'][] = site_url('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.ro.min.js');
		$this->content['javascript'][] = site_url('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.ro.min.js');
		$this->content['javascript'][] = site_url('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js');

		$this->content['javascript'][] = base_url().'assets/scripts/utilizator.js?v='.$this->config->item('css_js');


		if(!$this->session->userdata('loggedFrontend'))
			$this->layout['large'] = true;
		else 	$this->layout['large'] = false;
		$this->layout['sidebar'] = $this->load->view('utilizator/sidebar', '', true);
		$this->per_page = 10;
		$this->stari_factura = array(
			'1'		=> 'Neplatita',
			'2'		=> 'Platita',
			'3'		=> 'Anulata',
			'4'		=> 'Stornata'
		);
	}
	function index()
	{
		check_logged();
		$id = $this->session->userdata('tert_id');
		
		$utilizator = $this->utilizator_db->tert(array('id' => $id));
		$agent = array();
		if($utilizator['id_agent']!=0){
			//agent asociat direct
			$agent = $this->utilizator_db->agent(array('id' => $utilizator['id_agent']));
		} else {
			$agent_judet = $this->utilizator_db->agent_judet(array('judet' => $utilizator['judet']));
			if(is_array($agent_judet) and count($agent_judet)){
				//agnet alocat judetului
				$agent = $this->utilizator_db->agent(array('id' => $agent_judet['user_id']));
			}
		}
		$this->content['error_txt'] = validation_errors();
		$this->content['error'] = $this->load->view('error', $this->content, true);
		$this->content['utilizator'] = $utilizator;
		$this->content['agent'] = $agent;
		


		$this->content['tara'] = array_merge(array(''=>''), $this->config->item('tara'));
		$this->content['judet'] = array_merge(array(''=>''), $this->config->item('judet'));
		$this->layout['content'] = $this->load->view('utilizator/info', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	/*
	function index1()
	{
		check_logged();
		$id = $this->session->userdata('tert_id');
		$this->load->library('form_validation');
		// $this->form_validation->set_rules('email', lang('email'), 'trim|required');
		// $this->form_validation->set_rules('parola', lang('parola'), 'trim');
		$this->form_validation->set_rules('denumire', lang('nume_firma'), 'trim|required');
		$this->form_validation->set_rules('cod_fiscal', lang('cod_fiscal'), 'trim|required');
		$this->form_validation->set_rules('reg_com', lang('nr_reg_com'), 'trim|required');
		$this->form_validation->set_rules('oras', lang('oras'), 'trim|required');
		$this->form_validation->set_rules('cod_postal', lang('cod_postal'), 'trim');
		$this->form_validation->set_rules('adresa', lang('adresa'), 'trim|required');
		$this->form_validation->set_rules('tara', 'Tara firma', 'trim|required');
		$this->form_validation->set_rules('judet', lang('judet'), 'trim|required');
		// $this->form_validation->set_rules('telefon', lang('telefon'), 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$utilizator = $this->utilizator_db->tert(array('id' => $id));
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
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			$this->content['utilizator'] = $utilizator;
			$this->content['agent'] = $agent;
			


			$this->content['tara'] = array_merge(array(''=>''), $this->config->item('tara'));
			$this->content['judet'] = array_merge(array(''=>''), $this->config->item('judet'));
			$this->layout['content'] = $this->load->view('utilizator/utilizator', $this->content, true);
			$this->load->view('layout', $this->layout);
		}
		else
		{
			$rec = array(
				'denumire'		=> $this->input->post('denumire'),
				'cod_fiscal'	=> $this->input->post('cod_fiscal'),
				'reg_com'		=> $this->input->post('reg_com'),
				'tara'			=> $this->input->post('tara'),
				'judet'			=> $this->input->post('judet'),
				'oras'        	=> $this->input->post('oras'),
				'cod_postal'	=> $this->input->post('cod_postal'),
				'adresa'        => $this->input->post('adresa'),
				// 'telefon'		=> $this->input->post('telefon'),
				// 'email'			=> $this->input->post('email'),
				);
			if($this->input->post('parola')!='')
			{
				$rec['parola'] = md5($this->input->post('parola'));
			}
			$this->utilizator_db->actualizeaza($id, $rec);
			redirect('utilizator');
		}
	}
	*/
	function conectare(){
		$hash = $this->uri->segment(3);
		if($hash!='') {
			$rec = array(
				'hash' 			=> $hash,
				'activ'			=> 1,
				'confirmat'		=> 1,
				'magazin'		=> 'globiz'
				);
			$utilizator = $this->utilizator_db->utilizator($rec);
			if(is_array($utilizator) and count($utilizator)) {
				
				// if($this->session->userdata('loggedFrontend'))
				// 	$this->session->sess_destroy();
				$tert = $this->utilizator_db->tert(array('id' => $utilizator['tert_id']));
				
				$sess = array(
					'loggedFrontend'	=> true,
					'nume'				=> $utilizator['delegat'],
					'tert_id'			=> $utilizator['tert_id'],
					'id'				=> $utilizator['id'],
					'utilizator'		=> $utilizator['utilizator'],
					'email'				=> $utilizator['email'],
					'discount'			=> $tert['fara_discount']==1?-1:($tert['discount']==0?-1:$tert['discount']),
					'tip_pret'			=> $tert['tip_pret'],
					'feed_activ'		=> $tert['feed_activ'],
					'tara'				=> $tert['tara'],
					'dropshipping'		=> $tert['dropshipping'],
					'valoare_tva'		=> $tert['valoare_tva'],
					'gdpr'				=> $utilizator['gdpr'],
					'magazin'			=> 'globiz'
				);
				// print_R($sess);exit();
				$this->session->set_userdata($sess);
				$cookie = array(
					'name'   => 'LoginGlobiz',
					'value'  => $utilizator['id'],
					'expire' => 31556926, //1 year 
				);
				$this->input->set_cookie($cookie);
				// $this->cart->destroy();
				// $cos = $utilizator['cos'];
				// $cos_arr = unserialize($cos);
				// foreach ($cos_arr as $c) {
				// 	//print_r($cos);
				// 	$produs = $this->magazin_db->produs(array('id' => $c['id']));
				// 	if(count($produs)){
				// 		$data = array(
				// 			'id'      => $c['id'],
				// 			'qty'     => $c['qty'],
				// 			'price'   => $c['price'],
				// 			'name'    => $c['name'],
				// 			'options' => array('cod' => $produs['cod'])
				// 		);
				// 		$this->cart->insert($data);
				// 	}
				// }
				$this->cart->destroy();
				$cos = $utilizator['cos'];
				$cos_arr = unserialize($cos);
				if(is_array($cos_arr) and count($cos_arr)){
					foreach ($cos_arr as $no => $c) {
						$produs = $this->magazin_db->produs(array('id' => $c['id']));
						if(is_array($produs) and count($produs)){
							//print_r($c);
							if( isset($c['options']) and count($c['options']) ) {
								$options = $c['options'];
							} else {
								$produs = $this->magazin_db->produs(array('id' => $c['id']));
								if(is_array($produs) and count($produs)){
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
				//print_r(count($this->cart->contents()));
				//print_r($this->session->all_userdata());
				redirect('utilizator');
				exit();
			}

		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('utilizator', lang('utilizator'), 'trim|required');
		$this->form_validation->set_rules('parola', lang('parola'), 'trim|required|callback_check_login');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			$this->content['judet'] = array_merge(array(''=>''), $this->config->item('judet'));
			
			$this->layout['content'] = $this->load->view('utilizator/conectare', $this->content, true);
			$this->load->view('layout', $this->layout);
		}
		else
		{
			$rec = array(
				'utilizator'	=> $this->input->post('utilizator'),
				'parola'		=> md5($this->input->post('parola')),
				'activ'			=> 1,
				'confirmat'		=> 1,
				'magazin'		=> 'globiz'
			);
			$utilizator = $this->utilizator_db->utilizator($rec);
			$tert = $this->utilizator_db->tert(array('id' => $utilizator['tert_id']));

			$sess = array(
				'loggedFrontend'	=> true,
				'nume'				=> $utilizator['delegat'],
				'tert_id'			=> $utilizator['tert_id'],
				'id'				=> $utilizator['id'],
				'utilizator'		=> $utilizator['utilizator'],
				'email'				=> $utilizator['email'],
				'discount'			=> $tert['fara_discount']==1?-1:($tert['discount']==0?-1:$tert['discount']),
				'tip_pret'			=> $tert['tip_pret'],
				'feed_activ'		=> $tert['feed_activ'],
				'tara'				=> $tert['tara'],
				'dropshipping'		=> $tert['dropshipping'],
				'valoare_tva'		=> $tert['valoare_tva'],
				'gdpr'				=> $utilizator['gdpr'],
				'magazin'			=> 'globiz'
			);
			$this->session->set_userdata($sess);
			$cos = $utilizator['cos'];
			$cos_arr = unserialize($cos);
			foreach ($cos_arr as $c) {
				$data = array(
					'id'      => $c['id'],
					'qty'     => $c['qty'],
					'price'   => $c['price'],
					'name'    => $c['name']
				);
				$this->cart->insert($data);
			}
			redirect('utilizator');
		}
	}
	function inregistrare()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('utilizator', lang('utilizator'), 'trim|required|alpha_dash|is_unique[terti_utilizatori.utilizator]');
		$this->form_validation->set_rules('delegat', lang('nume'), 'trim|required');
		$this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|is_unique[terti_utilizatori.email]');
		$this->form_validation->set_rules('parola', lang('parola'), 'trim|required');
		$this->form_validation->set_rules('confirma_parola', lang('confirma_parola'), 'trim|matches[parola]');
		$this->form_validation->set_rules('denumire', lang('nume_firma'), 'trim|required');
		$this->form_validation->set_rules('cod_fiscal', lang('cod_fiscal'), 'trim|required');
		$this->form_validation->set_rules('reg_com', lang('nr_reg_com'), 'trim|required');
		$this->form_validation->set_rules('adresa', lang('adresa'), 'trim|required');
		$this->form_validation->set_rules('oras', lang('oras'), 'trim|required');
		$this->form_validation->set_rules('judet', lang('judet'), 'trim|required');
		$this->form_validation->set_rules('telefon', lang('telefon'), 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			$this->content['judet'] = array_merge(array(''=>''), $this->config->item('judet'));
			
			$this->layout['content'] = $this->load->view('utilizator/inregistrare', $this->content, true);
			$this->load->view('layout', $this->layout);
		}
		else
		{
			$rec = array(
				'denumire'			=> $this->input->post('denumire'),
				'cod_fiscal'		=> $this->input->post('cod_fiscal'),
				'reg_com'			=> $this->input->post('reg_com'),
				'judet'				=> $this->input->post('judet'),
				'oras'       	 	=> $this->input->post('oras'),
				'adresa'     	   => $this->input->post('adresa'),
				'email'				=> $this->input->post('email'),
				'telefon'			=> $this->input->post('telefon'),
				'data_inregistrati'	=> date('Y-m-d'),
				'tip_pret'			=> 4
				);
			$tert_id = $this->utilizator_db->adauga($rec);
			$rec = array(
				'judet'		=> $this->input->post('judet'),
				'adresa'	=> $this->input->post('adresa'),
				'oras'		=> $this->input->post('oras'),
				'implicit'	=> 1,
				'tert_id'	=> $tert_id
				);
			$this->utilizator_db->adauga_adresa_livrare($rec);
			$rec_utilizator = array(
				'utilizator'	=> $this->input->post('utilizator'),
				'delegat'		=> $this->input->post('delegat'),
				'parola'		=> md5($this->input->post('parola')),
				'email'			=> $this->input->post('email'),
				'telefon'		=> $this->input->post('telefon'),
				'tert_id'		=> $tert_id,
				'magazin'		=> 'globiz',
				'hash'			=> md5(uniqid(rand(), true)),
				'gdpr'			=> 1,
				'data_creare' 	=> date('Y-m-d H:i:s'),
				'ip_creare'		=> $_SERVER['REMOTE_ADDR']
				);
			$this->utilizator_db->adauga_utilizator($rec_utilizator);

			$agent = array();
			$agent_judet = $this->utilizator_db->agent_judet(array('judet' => $utilizator['judet']));
			if(is_array($agent_judet) and count($agent_judet)){
				//agnet alocat judetului
				$agent = $this->utilizator_db->agent(array('id' => $agent_judet['user_id']));
			}
			$rec_todo = array(
				'user_id'		=> (is_array($agent) and count($agent))?$agent['id']:16,
				'tert_id'		=> $tert_id,
				'tip_id'		=> 4,
				'tip_info'		=> $tert_id,
				'comanda_id'	=> 0,
				'data'			=> date('Y-m-d H:i:s'),
				'stare'			=> 0,
				'prioritate'	=> 0,
				'descriere'		=> 'Tert nou'
				);
			$this->magazin_db->adauga_to($rec_todo);
			redirect('utilizator/mesaj');
		}
	}
	function mesaj()
	{
		$this->content['titlu'] = lang('titlu_mesaj');
		$this->content['message'] = lang('corp_mesaj');
		$this->content['mesaj'] = $this->load->view('message', $this->content, true);
		$this->layout['content'] = $this->load->view('mesaj', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function check_login()
	{
		$rec = array(
			'utilizator'	=> $this->input->post('utilizator'),
			'parola'		=> md5($this->input->post('parola')),
			'activ'			=> 1,
			'confirmat'		=> 1,
			'magazin'		=> 'globiz'
		);
		$admin = $this->utilizator_db->utilizator($rec);
		if(!(is_array($admin) and count($admin)))
		{
			//$this->form_validation->set_message('check_login', 'Contul nu este activat sau nu exista.');
			$this->form_validation->set_message('check_login', 'Date de logare gresite.<br /><br />
				Pt resetare parola va rugam sa ne <a href="'.site_url('contact').'">contactati</a>. <br />
				Va multumim pt intelegere.');
			return FALSE;
		} return TRUE;
	}
	function deconectare()
	{
		$this->session->sess_destroy();
		$this->load->helper('cookie');
		delete_cookie("LoginGlobiz");
		redirect(site_url());
	}
	
	/********************/
	/* comenzi			*/
	/********************/
	function comenzi(){
		check_logged();
		$this->load->helper('form');
		$page = $this->uri->segment(3, 0);
		$data = $this->input->get('data');
		$comanda_id = $this->input->get('comanda_id');
		$stare = $this->input->get('stare');
		$stare_awb = $this->input->get('stare_awb');
		$stare_factura = $this->input->get('stare_factura');

		$sql_array = array();

		$where = array('tert_id' => $this->session->userdata('tert_id'));
		if($data!=''){
			$arr = explode("-", $data);
			$_data1 = str_replace("/", "-", $arr[0]);
			$_data1 = date('Y-m-d', strtotime($_data1));
			
			$_data2 = str_replace("/", "-", $arr[1]);
			$_data2 = date('Y-m-d', strtotime($_data2));
			
			$where['data >= '] = $_data1." 00:00:00";
			$where['data <= '] = $_data2." 23:59:59";
		}
		if($comanda_id!=''){
			$where['id'] = $comanda_id;
		}

		if($stare!=''){
			if($stare == 2){
				$sql_array[] = "stare IN (2,3,6,7,8)";
			} else {
				$where['stare'] = $stare;
			}
		}

		if($stare_awb!=''){
			if($stare_awb==1){
				$where['fisier_awb'] = '';
				$where['dropshipping'] = '1';
			} else {
				$where['fisier_awb !='] = '';
				$where['dropshipping'] = '1';
			}
		}
		if($stare_factura!=''){
			if($stare_factura==1){
				$where['fisier_factura'] = '';
				$where['dropshipping'] = '1';
			} else {
				$where['fisier_factura !='] = '';
				$where['dropshipping'] = '1';
			}
		}
		// print_r($where);exit();
		
		$sql = implode(" and ", $sql_array);
		$limits = array('per_page' => $this->per_page, 'no' => $page);
		$comenzi = $this->comenzi_db->comenzi($where, array('data'=>'desc', 'id'=>'desc'), $limits, $sql);
		foreach($comenzi as &$c){
			$plati = $this->comenzi_db->plati(array('comanda_id' => $c['id']));
			//$continut = $this->comenzi_db->continut(array('comanda_id' => $c['id']));
			// $total = 0;
			// foreach($continut as $cc){
			// 	$total+=$cc['total'];
			// }
			//$c['nr_produse'] = count($continut);
			//$comenzi[$k]['total'] = $total;
			$c['plata'] = $this->comenzi_db->plata(array('comanda_id' => $c['id']), array('data' => 'desc'));
		}
		$this->content['comenzi'] = $comenzi;
		
		$this->load->library('pagination');
		$config['base_url'] = site_url('utilizator/comenzi/');
		$config['total_rows'] = $this->comenzi_db->no_comenzi($where,$sql);
		$config['per_page'] = $this->per_page;
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-chevron-right"></i>';
		//$config['next_link'] = '<i class="fa fa-chevron-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 3;
		$config['num_links'] = 4;
		$config['suffix'] = $_SERVER['QUERY_STRING']!='' ? "?".$_SERVER['QUERY_STRING']:'';
		$config['first_url'] = site_url('utilizator/comenzi').$config['suffix'];
		$this->pagination->initialize($config);
		$stari = array(
			'1'		=> 'Neprocesata',
			'2'		=> 'Spre livrare',
			'4'		=> 'Anulata',
			'5'		=> 'Livrata'
		);
		$stari_document = array(
			'1'		=> 'lipsa document',
			'2'		=> 'incarcat',
		);
		$pages = $this->pagination->create_links();
		$this->content['pagini'] = $pages;
		$this->content['data'] = $data;
		$this->content['comanda_id'] = $comanda_id;
		$this->content['stare'] = $stare;
		$this->content['stare_awb'] = $stare_awb;
		$this->content['stare_factura'] = $stare_factura;
		$this->content['stari'] = array('' => 'Toate') + $stari;
		$this->content['stari_document'] = array('' => 'Toate') + $stari_document;
		$this->layout['content'] = $this->load->view('utilizator/comenzi', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function comanda(){
		check_logged();
		$id = $this->uri->segment(3);
		$where = array(
			'id'		=> $id,
			'tert_id' 	=> $this->session->userdata('tert_id')
		);
		$comanda = $this->comenzi_db->comanda($where);
		if(!(is_array($comanda) and count($comanda))) {redirect('utilizator/comenzi'); exit();}
		$redirect = false;
		if(isset($_FILES['fisier_factura']) and ($_FILES['fisier_factura']['name'])){
			$config['upload_path'] = $this->config->item('media_path').'terti/';
			$config['allowed_types'] = '*';
			$this->load->library('upload', $config);
			if ( $this->upload->do_upload('fisier_factura'))
			{
				$file_arr = $this->upload->data();
				$this->comenzi_db->actualizeaza($id, array('fisier_factura' => $file_arr['file_name']));
				$redirect = true;
			} else{
				$this->upload->display_errors();
			}
		}
		if(isset($_FILES['fisier_awb']) and ($_FILES['fisier_awb']['name'])){
			$config['upload_path'] = $this->config->item('media_path').'terti/';
			$config['allowed_types'] = '*';
			$this->load->library('upload', $config);
			if ( $this->upload->do_upload('fisier_awb'))
			{
				$file_arr = $this->upload->data();
				$this->comenzi_db->actualizeaza($id, array('fisier_awb' => $file_arr['file_name']));
				$redirect = true;
			}
		}
		if($redirect){
			redirect('utilizator/comanda/'.$id);
			exit();
		}
		
		$continut = $this->comenzi_db->continut(array('comanda_id' => $comanda['id']));
		foreach($continut as $k=>$c){
			$produs = $this->magazin_db->produs(array('id' => $c['articol_id']));
			$continut[$k]['produs'] = $produs;
			$continut[$k]['imagine'] = $this->magazin_db->produse_imagine(array('articol_id' => $produs['id']), array('ordine' => 'asc'));;
		}
		$comanda['plata'] = $this->comenzi_db->plata(array('comanda_id' => $id));
		$this->content['comanda'] = $comanda;
		$this->content['continut'] = $continut;
		$this->content['plata'] = $this->comenzi_db->plata(array('comanda_id' => $id), array('data' => 'desc'));
		$this->content['adresa_livrare'] = $this->utilizator_db->adresa_livrare(array('id' => $comanda['adresa_id']));
		$this->content['judete'] = $this->config->item('judet');
		$this->content['tara'] = $this->config->item('tara');
		
		$this->layout['content'] = $this->load->view('utilizator/comanda', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function plateste_comanda(){
		$id = $this->uri->segment(3);
		$where = array(
			'id'		=> $id,
			'tert_id' 	=> $this->session->userdata('tert_id')
		);
		$comanda = $this->comenzi_db->comanda($where);
		if(!(is_array($comanda) and count($comanda))) {redirect('utilizator/comenzi'); exit();}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('denumire', lang('nume_firma'), 'trim');
		$this->form_validation->set_rules('cod_fiscal', lang('cod_fiscal'), 'trim');
		$this->form_validation->set_rules('reg_com', lang('nr_reg_com'), 'trim');
		$this->form_validation->set_rules('adresa', lang('adresa'), 'trim|required');
		$this->form_validation->set_rules('oras', lang('oras'), 'trim|required');
		$this->form_validation->set_rules('cod_postal', lang('cod_postal'), 'trim|required');
		$this->form_validation->set_rules('judet', lang('judet'), 'trim|required');
		$this->form_validation->set_rules('nume', lang('nume'), 'trim|required');
		$this->form_validation->set_rules('prenume', lang('prenume'), 'trim|required');
		$this->form_validation->set_rules('telefon', lang('telefon'), 'trim|required');
		$this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			$comanda['tert'] = $this->utilizator_db->tert(array('id' => $comanda['tert_id']));
			$comanda['tert_utilizator'] = $this->utilizator_db->utilizator(array('id' => $comanda['tert_utilizator_id']));
			
			$this->content['comanda'] = $comanda;
			$this->content['judet'] = array('' => '')+$this->config->item('judet');

			$this->layout['content'] = $this->load->view('utilizator/plateste_comanda', $this->content, true);
			$this->load->view('layout', $this->layout);
		} else {
			$continut = $this->comenzi_db->continut(array('comanda_id' => $comanda['id']));
			foreach($continut as &$c){
				$produs = $this->magazin_db->produs(array('id' => $c['articol_id']));
				$c['produs'] = $produs;

			}
			$id_client = $comanda['tert_id'];
			$comanda['tert'] = $this->utilizator_db->tert(array('id' => $id_client));
			$comanda['tert_utilizator'] = $this->utilizator_db->utilizator(array('id' => $comanda['tert_utilizator_id']));
			$comanda['adresa_livrare'] = $this->utilizator_db->adresa_livrare(array('id' => $comanda['adresa_id']));

			$this->content['continut'] = $continut;
			$this->content['comanda'] = $comanda;
			$this->content['date'] = $this->input->post();

			$this->layout['content'] = $this->load->view('utilizator/timite_plata', $this->content);
		}
	}
	function raspuns_tranzactie(){
		include("./PlatiOnlineRo/clspo.php");
		include("./PlatiOnlineRo/RSALib.php");
		$my_class = new PO3();

		$my_class->LoginID = $lid;
		$my_class->KeyEnc = $ke;
		$my_class->KeyMod = $km;
		
		$vF_Message_Relay =			$_REQUEST["F_MESSAGE_RELAY"];
		$vF_Crypt_Message_Relay = 	$_REQUEST["F_CRYPT_MESSAGE_RELAY"];
		$vX_RESPONSE_CODE = 		$_REQUEST["X_RESPONSE_CODE"];
		$vX_RESPONSE_REASON_TEXT = 	$_REQUEST["X_RESPONSE_REASON_TEXT"];
		$vF_ORDER_NUMBER = 			$_REQUEST["F_ORDER_NUMBER"];
		$vF_Amount = 				$_REQUEST["F_AMOUNT"];
		$vF_Currency = 				strtoupper($_REQUEST["F_CURRENCY"]);
		$vX_TRAN_ID =				$_REQUEST["X_TRAN_ID"];
		$vMy_F_Message_Relay =		strtoupper($my_class->VerifyFRM(strval($vF_Message_Relay)));

		// make sure the response it is from PlatiOnline.ro servers
		if($vF_Crypt_Message_Relay!=$vMy_F_Message_Relay)
			die("<h3>Error!</h3><p>hacking attempt.[Relay Message]</p>");

		$vA = explode("^", $vF_Message_Relay);

		// if the curency do not match with the message currency decline the transaction
		$vCurrencyMessage = $vA[4];

		if($vCurrencyMessage != $vF_Currency)
			die("<h3>Error!</h3><p>Hacking attempt.[Currency Relay Message]</p>");

		// if the amount do not match with the message amount decline the transaction
		$vAmountMessage = $vA[3];
		if($vAmountMessage != round($vF_Amount, 2))  
			die("<h3>Error!</h3><p>Hacking attempt.[Amount Relay Message]</p>");
		// if the response code do not match with the message response code decline the transaction

		$vX_Response_Code_Message = $vA[5];

		if($vX_RESPONSE_CODE != $vX_Response_Code_Message)
			die("<h3>Error!</h3><p>Hacking attempt.[Response Code Relay Message]</p>");

		$vX_TRAN_ID_Message = $vA[7];

		if($vX_TRAN_ID != $vX_TRAN_ID_Message)
			die("<h3>Error!</h3><p>Hacking attempt.[Tranzaction ID Relay Message]</p>");

		// ATENTIE
		// validare ca nu e refresh
		// dupa tot F_Message sau doar dupa stampul din F_Message
		// daca e refresh atunci NU treb sa inregistrezi duplicat rezultatul
		$vReponseStamp = $vA[2];
		// END PlatiOnline.ro
		//  -------------

		$cod_tranzactie = $vX_TRAN_ID;
		$comanda_id = $vF_ORDER_NUMBER;
		$suma = $vF_Amount;
		$cod_raspuns = $vX_RESPONSE_CODE;
		$text_raspuns = $vX_RESPONSE_REASON_TEXT;

		switch($vX_RESPONSE_CODE) {
			case '2':
				//	aprobata - actualizati statusul comenzii in magazinul dvs.
				$raspuns = 'Plata pentru comanda {comanda_id} a fost aprobata.';
				break;
			case '13':
				//	on hold - actualizati statusul comenzii in magazinul dvs.
				$raspuns = 'Tranzactia pentru comanda {comanda_id} necesita verificari suplimentare';
				break;
			case '8':
				//	refuzata - actualizati statusul comenzii in magazinul dvs.
				$raspuns = 'Plata pentru comanda {comanda_id} este refuzata';
				break;
			case '10':
				//	eroare - actualizati statusul comenzii in magazinul dvs.
				$raspuns = 'A aparut o eroare in plata comenzii {comanda_id}';
				break;
		}
		$plata = $this->comenzi_db->plata(array('cod_tranzactie' => $cod_tranzactie));
		if(!(is_array($plata) and count($plata))) {
			$rec = array(
				'comanda_id'		=> $comanda_id,
				'cod_tranzactie'	=> $cod_tranzactie,
				'suma'				=> $suma,
				'data'				=> date('Y-m-d H:i:s'),
				'cod_raspuns'		=> $cod_raspuns,
				'text_raspuns'		=> $text_raspuns
				);
			$this->comenzi_db->adauga_plata($rec);
		}
		$link =  '<a href="'.site_url('utilizator/comanda/'.$comanda_id).'">'.$comanda_id.'</a>';
		$raspuns = str_replace('{comanda_id}', $link, $raspuns);

		$this->content['raspuns'] = $raspuns;
		$this->content['comanda_id'] = $comanda_id;

		$this->layout['content'] = $this->load->view('utilizator/raspuns_tranzactie', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	/********************/
	/* adrese_livrare	*/
	/********************/
	function adrese_livrare(){
		check_logged();
		$id = $this->session->userdata('tert_id');
		$adrese = $this->utilizator_db->adrese_livrare(array('tert_id' => $id));
		$this->content['adrese'] = $adrese;
		$this->content['tara'] = $this->config->item('tara');
		$this->content['judet'] = $this->config->item('judet');
		$this->layout['content'] = $this->load->view('utilizator/adrese_livrare', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function editare_adresa_livrare()
	{
		check_logged();
		$tert_id = $this->session->userdata('tert_id');
		$id = $this->uri->segment(3);
		$adresa = $this->utilizator_db->adresa_livrare(array('id' => $id, 'tert_id' => $tert_id));
		if(!(is_array($adresa) and count($adresa))) {redirect('utilizator/adresa_livrare'); exit();}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('tara', lang('tara'), 'trim|required');
		$this->form_validation->set_rules('judet', lang('judet'), 'trim|required');
		$this->form_validation->set_rules('oras', lang('oras'), 'trim|required');
		$this->form_validation->set_rules('adresa', lang('adresa'), 'trim|required');
		$this->form_validation->set_rules('cod_postal', lang('cod_postal'), 'trim');
		if ($this->form_validation->run() == FALSE)
		{
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			$this->content['tara'] = array_merge(array(''=>''), $this->config->item('tara'));
			$this->content['judet'] = array_merge(array(''=>''), $this->config->item('judet'));
			$localitati = array();
			$_locArr = $this->utilizator_db->localitati(array('county_abr' => set_value('judet', $adresa['judet'])), array('nume' => 'asc'));
			foreach ($_locArr as $l) {
				$_nume = ucwords(strtolower($l['nume']));
				$localitati[$_nume] = $_nume;
			}
			$this->content['localitati'] = array_merge(array(''=>lang('oras')), $localitati);
			$this->content['adresa'] = $adresa;
			$this->layout['content'] = $this->load->view('utilizator/editare_adrese_livrare', $this->content, true);
			$this->load->view('layout', $this->layout);
		}
		else
		{
			$rec = array(
				'tara'			=> $this->input->post('tara'),
				'judet'			=> $this->input->post('judet'),
				'adresa'		=> $this->input->post('adresa'),
				'cod_postal'	=> $this->input->post('cod_postal'),
				'oras'			=> $this->input->post('oras'),
				);
			$this->utilizator_db->actualizeaza_adresa_livrare($id, $rec);
			redirect('utilizator/adrese_livrare');
		}
	}
	function adauga_adresa_livrare()
	{
		check_logged();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('tara', lang('tara'), 'trim|required');
		$this->form_validation->set_rules('judet', lang('judet'), 'trim|required');
		$this->form_validation->set_rules('oras', lang('oras'), 'trim|required');
		$this->form_validation->set_rules('adresa', lang('adresa'), 'trim|required');
		$this->form_validation->set_rules('cod_postal', lang('cod_postal'), 'trim');
		if ($this->form_validation->run() == FALSE)
		{
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);

			// $this->content['error'] = validation_errors();
			// $this->content['error'] = $this->load->view('error', $this->content, true);
			$localitati = array();
			$_locArr = $this->utilizator_db->localitati(array('county_abr' => set_value('judet')), array('nume' => 'asc'));
			foreach ($_locArr as $l) {
				$_nume = ucwords(strtolower($l['nume']));
				$localitati[$_nume] = $_nume;
			}

			$this->content['tara'] = array_merge(array(''=>lang('tara')), $this->config->item('tara'));
			$this->content['judet'] = array_merge(array(''=>lang('judet')), $this->config->item('judet'));
			$this->content['localitati'] = array_merge(array(''=>lang('oras')), $localitati);
			$this->layout['content'] = $this->load->view('utilizator/adauga_adresa_livrare', $this->content, true);
			$this->load->view('layout', $this->layout);
		}
		else
		{
			$rec = array(
				'tara'			=> $this->input->post('tara'),
				'judet'			=> $this->input->post('judet'),
				'adresa'		=> $this->input->post('adresa'),
				'oras'			=> $this->input->post('oras'),
				'cod_postal'	=> $this->input->post('cod_postal'),
				'tert_id' 		=> $this->session->userdata('tert_id')
				);
			$this->utilizator_db->adauga_adresa_livrare($rec);
			redirect('utilizator/adrese_livrare');
		}
	}
	function sterge_adresa_livrare(){
		$id = $this->input->post('id');
		$tert_id = $this->session->userdata('tert_id');
		$adresa = $this->utilizator_db->adresa_livrare(array('id' => $id, 'tert_id' => $tert_id));
		if(!(is_array($adresa) and count($adresa))) {
			$res['type'] = 'error';
			$res['msg'] = 'Adresa nu exista';
		}else{
			if($adresa['implicit']){
				$res['type'] = 'error';
				$res['msg'] = 'Nu se poate sterge o adresa implicita.';
			} else {
				$res['type'] = 'ok';
				$this->utilizator_db->sterge_adresa_livrare(array('id' => $id));
			}
		}
		
		echo json_encode($res);
	}
	function schimba_adresa_implicita(){
		$id = $this->input->post('id');
		$tert_id = $this->session->userdata('tert_id');
		$adresa = $this->utilizator_db->adresa_livrare(array('id' => $id, 'tert_id' => $tert_id));
		if(is_array($adresa) and count($adresa)){
			$adrese = $this->utilizator_db->adrese_livrare(array('tert_id' => $adresa['tert_id']));
			foreach ($adrese as $adr) {
				$this->utilizator_db->actualizeaza_adresa_livrare($adr['id'], array('implicit' => 0));
			}
			$this->utilizator_db->actualizeaza_adresa_livrare($id, array('implicit' => 1));
		}
	}
	/********************/
	/* utilizatori		*/
	/********************/
	function utilizatori(){
		check_logged();
		$id = $this->session->userdata('tert_id');
		$utilizatori = $this->utilizator_db->utilizatori(array('tert_id' => $id));

		$this->content['utilizatori'] = $utilizatori;
		$this->layout['content'] = $this->load->view('utilizator/utilizatori', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function editare_utilizator(){
		check_logged();
		$id = $this->uri->segment(3);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('telefon', lang('telefon'), 'trim');
		$this->form_validation->set_rules('email', lang('email'), 'trim|valid_email|required');
		$this->form_validation->set_rules('delegat', lang('nume'), 'trim|required');
		//$this->form_validation->set_rules('serie_ci', lang('serie_ci'), 'trim');
		//$this->form_validation->set_rules('numar_ci', lang('numar_ci'), 'trim');
		//$this->form_validation->set_rules('politie_ci', lang('eliberat_de'), 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{

			$utilizator = $this->utilizator_db->utilizator(array('id' => $id));
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			$this->content['utilizator'] = $utilizator;

			$this->layout['content'] = $this->load->view('utilizator/editare_utilizator', $this->content, true);
			$this->load->view('layout', $this->layout);
		} else {
			$confirmat = 1;
			$rec = array(
				'telefon'       	=> $this->input->post('telefon'),
				'email'         	=> $this->input->post('email'),
				'delegat'       	=> $this->input->post('delegat'),
				'data_actualizare'	=> date('Y-m-d H:i:s'),
				'ip_actualizare'	=> $_SERVER['REMOTE_ADDR'],
				//'serie_ci'      => $this->input->post('serie_ci'),
				//'numar_ci'      => $this->input->post('numar_ci'),
				//'politie_ci'    => $this->input->post('politie_ci')
				);
			if($this->input->post('parola')!='')
				$rec['parola'] = md5($this->input->post('parola'));
			$this->utilizator_db->actualizeaza_utilizator($id, $rec);
			redirect('utilizator/editare_utilizator/'.$id);
		}
	}
	function adauga_utilizator(){
		check_logged();
		$this->load->library('form_validation');

		$this->form_validation->set_rules('utilizator', lang('utilizator'), 'trim|required|is_unique[terti.utilizator]');
		$this->form_validation->set_rules('parola', lang('parola'), 'trim|required');
		$this->form_validation->set_rules('telefon', lang('telefon'), 'trim');
		$this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|is_unique[terti.email]');
		$this->form_validation->set_rules('delegat', lang('nume'), 'trim|required');
		// $this->form_validation->set_rules('serie_ci', lang('serie_ci'), 'trim');
		// $this->form_validation->set_rules('numar_ci', lang('numar_ci'), 'trim');
		// $this->form_validation->set_rules('politie_ci', lang('eliberat_de'), 'trim');
		if ($this->form_validation->run() == FALSE)
		{
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);

			$this->layout['content'] = $this->load->view('utilizator/adauga_utilizator', $this->content, true);
			$this->load->view('layout', $this->layout);
		} else {
			$confirmat = 1;
			$rec = array(
				'utilizator'    => $this->input->post('utilizator'),
				'telefon'       => $this->input->post('telefon'),
				'email'         => $this->input->post('email'),
				'delegat'       => $this->input->post('delegat'),
				// 'serie_ci'      => $this->input->post('serie_ci'),
				// 'numar_ci'      => $this->input->post('numar_ci'),
				// 'politie_ci'    => $this->input->post('politie_ci'),
				'confirmat'		=> $confirmat,
				'tert_id'		=> $this->session->userdata('tert_id'),
				'parola'		=> md5($this->input->post('parola')),
				'magazin'		=> 'globiz',
				'hash'			=> md5(uniqid(rand(), true)),
				'gdpr'			=> 1,
				'data_creare' 	=> date('Y-m-d H:i:s'),
				'ip_creare'		=> $_SERVER['REMOTE_ADDR']
				);
			$id = $this->utilizator_db->adauga_utilizator($rec);
			redirect('utilizator/editare_utilizator/'.$id);
		}

	}
	function sterge_utilizator(){
		$id = $this->input->post('id');
		$this->utilizator_db->sterge_utilizator(array('id' => $id));
	}
	/********************/
	/* end utilizatori	*/
	/********************/
	function resetareparola(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('utilizator', lang('utilizator'), 'trim|required|callback_check_exist');
		$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run() == FALSE)
		{
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			$this->layout['content'] = $this->load->view('utilizator/resetareparola', $this->content, true);
			$this->load->view('layout', $this->layout);
		}
		else
		{
			$this->email_resetare();
		}
	}
	function check_exist(){
		$rec = array(
			'utilizator'	=> $this->input->post('utilizator'),
			'activ'			=> 1,
			'confirmat'		=> 1,
			'magazin'		=> 'globiz'
		);
		$admin = $this->utilizator_db->utilizator($rec);
		if(!(is_array($admin) and count($admin)))
		{
			$this->form_validation->set_message('check_exist', 'Ne pare rau dar contul nu exista.');
			return FALSE;
		} return TRUE;
	}
	
	function email_resetare(){
		if($this->input->post('utilizator')!='')
		{
			$rec = array(
				'utilizator'	=> $this->input->post('utilizator'),
				'magazin'		=> 'globiz'
			);
			$user = $this->utilizator_db->utilizator($rec);
			if(is_array($user) and count($user))
			{
				$salt = md5($user['id'].'carguard'.time());
				$link = site_url('utilizator/schimbaparola/'.$salt);
				$mesaj = 'Pentru a schimba parola executati un click <a href="'.$link.'">aici</a>, sau copiati link-ul de mai jos in browser. <br /><br />'.$link;
				
				$config['smtp_host'] = $this->config->item('host_name');
				$config['smtp_user'] = $this->config->item('user_email');
				$config['smtp_pass'] = $this->config->item('password_email');
				$config['mailtype'] = 'html';
				$config['protocol'] = 'smtp';
				
				$this->load->library('email');
				$this->email->initialize($config);
				$this->email->from($this->config->item('from_email'), 'Globiz');
				$this->email->to($user['email']);
				
				$this->email->subject('Globiz: Resetare parola');
				$this->email->message($mesaj);
				
				if(!$this->email->send()){
					echo $this->email->print_debugger();
				} else {
					$rec = array(
						'salt'	=> $salt
					);
					$this->utilizator_db->actualizeaza_utilizator($user['id'], $rec);
					//echo $this->db->last_query();
					$this->session->set_flashdata('message', 'Pe adresa de email asociata contului veți primi un mesaj cu un link pentru a reseta parola.');
					$this->session->set_flashdata('titlu', 'Resetare parola');
					redirect('utilizator/mesaj_resetare_parola');
				}
			} else {
				redirect(site_url());
			}
		} else {
			redirect(site_url());
		}
	}
	function schimbaparola(){
		$str = $this->uri->segment(3);
		$rec = array(
			'salt'			=> $str,
			'magazin'		=> 'globiz'
		);
		$user = $this->utilizator_db->utilizator($rec);
		if(is_array($user) and count($user)){
			$this->session->sess_destroy();
			$this->load->helper('cookie');
			delete_cookie("LoginGlobiz");
			$this->load->library('form_validation');
			$this->form_validation->set_rules('parola', lang('parola'), 'trim|required');
			$this->form_validation->set_rules('confirma_parola', lang('confirma_parola'), 'trim|required|matches[parola]');
			$this->form_validation->set_error_delimiters('', '<br>');
			if ($this->form_validation->run() == FALSE)
			{
				$this->content['error_txt'] = validation_errors();
				$this->content['error'] = $this->load->view('error', $this->content, true);
				$this->content['str'] = $str;
				
				$this->layout['content'] = $this->load->view('utilizator/schimbaparola', $this->content, true);
				$this->load->view('layout', $this->layout);
			} else {
				$rec_update = array(
					'parola'	=> md5($this->input->post('parola')),
					'salt'		=> ''
				);
				$this->utilizator_db->actualizeaza_utilizator($user['id'], $rec_update);
				$this->session->set_flashdata('message', 'Parola a fost schimbata.');
				$this->session->set_flashdata('titlu', 'Schimba parola');
				redirect('mesaj');
			}
			
		} else {
			redirect(site_url());
		}
	}
	function mesaj_resetare_parola(){
		$this->layout['content'] = $this->load->view('utilizator/mesaj_resetare_parola', $this->content, true);
		$this->load->view('layout', $this->layout);
	}

	/****************/
	/* feed-uri 	*/
	/****************/
	function feeduri(){
		check_logged();
		$this->content['tert'] = $this->utilizator_db->tert(array('id' => $this->session->userdata('tert_id')));
		$this->layout['content'] = $this->load->view('utilizator/feeduri', $this->content, true);
		$this->load->view('layout', $this->layout);
	}

	function login()
	{
		$action = $this->input->post('action') ? $this->input->post('action') : FALSE;
		if (! $action )
		{
			$this->content['tara'] = array_merge(array(''=>lang('tara')), $this->config->item('tara'));
			$this->content['judet'] = array_merge(array(''=>lang('judet')), $this->config->item('judet'));
			$this->content['localitati'] = array(''=>lang('oras'));
			$this->layout['content'] = $this->load->view('utilizator/login', $this->content, true);
			$this->layout['current_page'] = 'inregistrare';
			$this->load->view('layout', $this->layout);
		}
		elseif ($action == 'login')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('utilizator', lang('utilizator'), 'trim|required');
			$this->form_validation->set_rules('parola', lang('parola'), 'trim|required|callback_check_login');			
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->content['error_txt'] = validation_errors();
				$this->content['error_login'] = $this->load->view('error', $this->content, true);
				$this->content['tara'] = array_merge(array(''=>lang('tara')), $this->config->item('tara'));
				$this->content['judet'] = array_merge(array(''=>lang('judet')), $this->config->item('judet'));
				$this->content['localitati'] = array(''=>lang('oras'));
				
				$this->layout['content'] = $this->load->view('utilizator/login', $this->content, true);
				$this->load->view('layout', $this->layout);
			}
			else
			{
				$rec = array(
					'utilizator'	=> $this->input->post('utilizator'),
					'parola'		=> md5($this->input->post('parola')),
					'activ'			=> 1,
					'confirmat'		=> 1,
					'magazin'		=> 'globiz'
				);

				$utilizator = $this->utilizator_db->utilizator($rec);
				$tert = $this->utilizator_db->tert(array('id' => $utilizator['tert_id']));
				
				$sess = array(
					'loggedFrontend'=> true,
					'nume'			=> $utilizator['delegat'],
					'tert_id'		=> $utilizator['tert_id'],
					'id'			=> $utilizator['id'],
					'utilizator'	=> $utilizator['utilizator'],
					'email'			=> $utilizator['email'],
					'tara'			=> $tert['tara'],
					'valoare_tva'	=> $tert['valoare_tva'],
					'discount'			=> $tert['fara_discount']==1?-1:($tert['discount']==0?-1:$tert['discount']),
					'tip_pret'			=> $tert['tip_pret'],
					'feed_activ'	=> $tert['feed_activ'],
					'dropshipping'	=> $tert['dropshipping'],
					'gdpr'			=> $utilizator['gdpr'],
					'magazin'		=> 'globiz'
				);
				$this->session->set_userdata($sess);
				$cookie = array(
					'name'   => 'LoginGlobiz',
					'value'  => $utilizator['id'],
					'expire' => 31556926, //1 year 
				);
				$this->input->set_cookie($cookie);
				//$_c = $this->input->cookie('LoginGlobiz', true);
				//print_r($_c);
				//exit();
				$this->cart->destroy();
				$cos = $utilizator['cos'];
				$cos_arr = unserialize($cos);
				//print_r($cos_arr);
				if(is_array($cos_arr) and count($cos_arr)){
					foreach ($cos_arr as $c) {
						$produs = $this->magazin_db->produs(array('id' => $c['id']));
						//print_r($c);
						if(is_array($produs) and count($produs)){
							if( isset($c['options']) and count($c['options']) ) {
								$options = $c['options'];
							} else {
								$produs = $this->magazin_db->produs(array('id' => $c['id']));
								if(is_array($produs) and count($produs)){
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
				redirect('utilizator');
			}

		}
		elseif ($action == 'inregistrare')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('utilizator', lang("utilizator"), 'trim|required|alpha_dash|is_unique[terti_utilizatori.utilizator]');
			$this->form_validation->set_rules('delegat', lang("nume"), 'trim|required');
			$this->form_validation->set_rules('email', lang("email"), 'trim|required|valid_email|is_unique[terti_utilizatori.email]');
			$this->form_validation->set_rules('parola', lang("parola"), 'trim|required');
			$this->form_validation->set_rules('confirma_parola', lang("email"), 'trim|matches[parola]');
			$this->form_validation->set_rules('denumire', lang("nume_firma"), 'trim|required');
			$this->form_validation->set_rules('cod_fiscal', lang("cod_fiscal"), 'trim|required|callback_verificare_codfiscal');
			$this->form_validation->set_rules('reg_com', lang("nr_reg_com"), 'trim|required');
			$this->form_validation->set_rules('tara', lang("tara"), 'trim|required');
			$this->form_validation->set_rules('judet', lang("judet"), 'trim|required');
			$this->form_validation->set_rules('oras', lang("oras"), 'trim|required');
			$this->form_validation->set_rules('adresa', lang("adresa"), 'trim|required');
			$this->form_validation->set_rules('telefon', lang("telefon"), 'trim|required');
			//$this->form_validation->set_rules('acrod_termeni_conditii', lang("acrod_termeni_conditii"), 'trim|required');
			//$this->form_validation->set_rules('acrod_gdpr', lang("acrod_gdpr"), 'trim|required');
			$this->form_validation->set_error_delimiters('', '<br>');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->content['error_txt'] = validation_errors();
				$this->content['error'] = $this->load->view('error', $this->content, true);
				$this->content['tara'] = array_merge(array(''=>'TARA'), $this->config->item('tara'));
				$this->content['judet'] = array_merge(array(''=>'JUDET'), $this->config->item('judet'));
				$localitati = array();
				$_locArr = $this->utilizator_db->localitati(array('county_abr' => set_value('judet')), array('nume' => 'asc'));
				foreach ($_locArr as $l) {
					$_nume = ucwords(strtolower($l['nume']));
					$localitati[$_nume] = $_nume;
				}
				$this->content['localitati'] = array_merge(array(''=>lang('oras')), $localitati);
						
				$this->layout['content'] = $this->load->view('utilizator/login', $this->content, true);
				$this->load->view('layout', $this->layout);
			}
			else
			{
				$this->load->library('sendmachine', array('username' => '79e8dgc1hu1f6qonlk9poivn3w7ycjpj', 'password' => 't3s6j5800af604ulo3bdl71p39oftdzm'));
				$rec = array(
					'denumire'			=> $this->input->post('denumire'),
					'cod_fiscal'		=> $this->input->post('cod_fiscal'),
					'reg_com'			=> $this->input->post('reg_com'),
					'tara'				=> $this->input->post('tara'),
					'judet'				=> $this->input->post('judet'),
					'oras'       	 	=> $this->input->post('oras'),
					'adresa'     	   => $this->input->post('adresa'),
					'email'				=> $this->input->post('email'),
					'telefon'			=> $this->input->post('telefon'),
					'data_inregistrati'	=> date('Y-m-d'),
					'tip_pret'			=> 4
					);
				$companie = $this->magazin_db->companie(array('id' => 1));
				$rec['valoare_tva'] = $companie['tva'];
				if($this->input->post('tara')!='RO'){
					$rec['id_agent'] = 16;
				}
				$tert_id = $this->utilizator_db->adauga($rec);
				$rec = array(
					'tara'		=> $this->input->post('tara'),
					'judet'		=> $this->input->post('judet'),
					'adresa'	=> $this->input->post('adresa'),
					'oras'		=> $this->input->post('oras'),
					'implicit'	=> 1,
					'tert_id'	=> $tert_id
					);
				$this->utilizator_db->adauga_adresa_livrare($rec);
				$rec_utilizator = array(
					'utilizator'		=> $this->input->post('utilizator'),
					'delegat'			=> $this->input->post('delegat'),
					'parola'			=> md5($this->input->post('parola')),
					'email'				=> $this->input->post('email'),
					'telefon'			=> $this->input->post('telefon'),
					'tert_id'			=> $tert_id,
					'magazin'			=> 'globiz',
					'hash'				=> md5(uniqid(rand(), true)),
					'data_creare'		=> date('Y-m-d H:i:s'),
					'ip_creare'			=> $_SERVER['REMOTE_ADDR'],
					'gdpr'				=> 1,
					'data_actualizare'	=> date('Y-m-d H:i:s'),
					'ip_actualizare'	=> $_SERVER['REMOTE_ADDR'],
					);
				$this->utilizator_db->adauga_utilizator($rec_utilizator);
				$this->sendmachine->manage_contacts(6, [$this->input->post('email')], 'subscribe');
				$agent = array();
				if($this->input->post('tara')=='RO'){
					$agent_judet = $this->utilizator_db->agent_judet(array('judet' => $this->input->post('judet')));
					if(is_array($agent_judet) and count($agent_judet)){
						//agent alocat judetului
						$agent = $this->utilizator_db->agent(array('id' => $agent_judet['user_id']));
					}
				} else {
					$agent = $this->utilizator_db->agent(array('id' => 16));
				}
				$rec_todo = array(
					'user_id'		=> (is_array($agent) and count($agent))?$agent['id']:16,
					'tert_id'		=> $tert_id,
					'tip_id'		=> 4,
					'tip_info'		=> $tert_id,
					'comanda_id'	=> 0,
					'data'			=> date('Y-m-d H:i:s'),
					'stare'			=> 0,
					'prioritate'	=> 0,
					'descriere'		=> 'Tert nou'
					);
				$this->magazin_db->adauga_to($rec_todo);
				redirect('utilizator/mesaj');
			}

		}
	}
	function verificare_codfiscal(){
		$cui = $this->input->post('cod_fiscal');
		$cui = cui($cui);
		$sql = 'cod_fiscal LIKE "%'.$cui.'"';
		$tert = $this->utilizator_db->tert(array(), $sql);
		if(is_array($tert) and count($tert)){
			$this->form_validation->set_message('verificare_codfiscal', lang('Codul fiscal a mai fost folosit o data.'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	function schimbat_judet(){
		$localitati = array(''=>lang('oras'));
		$_locArr = $this->utilizator_db->localitati(array('county_abr' => $this->input->post('judet')), array('nume' => 'asc'));
		foreach ($_locArr as $l) {
			$_nume = ucwords(strtolower($l['nume']));
			$localitati[$_nume] = $_nume;
		}
		echo form_dropdown('oras', $localitati, set_value('oras'), 'class="form-control selectpicker" data-style="btn-select" id="oras" data-live-search="true" data-width="100%" data-toggle="tooltip"');
	}
	function schimbat_tara(){
		$rezultat = array();
		$tara = $this->input->post('tara');
		if($tara!='RO'){
			$rezultat['judet'] = '<input type="text" name="judet" value="" placeholder="'.lang('judet').'" class="form-control" />';
			$rezultat['oras'] = '<input type="text" name="oras" value="" placeholder="'.lang('oras').'" class="form-control" />';
		} else {
			$judet = array_merge(array(''=>lang('judet')), $this->config->item('judet'));
			$localitati = array(''=>lang('oras'));
			$rezultat['judet'] = form_dropdown('judet', $judet, '','class="form-control selectpicker" id="judet" data-live-search="true" data-width="100%" data-style="btn-select" data-toggle="tooltip" onchange="schimbat_judet()"');;
			$rezultat['oras'] = form_dropdown('oras', $localitati, '', 'class="form-control selectpicker" data-style="btn-select" id="oras" data-live-search="true" data-width="100%" data-toggle="tooltip"' );
		}
		echo json_encode($rezultat);
	}
	/********************/
	/* garantii			*/
	/********************/
	function garantii()
	{
		check_logged();
		$this->load->helper('form');
		$no = $this->uri->segment(3, 0);

		$where_arr = array('tert_id' => $this->session->userdata('tert_id'));
		$limits = array('per_page' => $this->per_page, 'no' => $no);
		$order = array('data' => 'desc');
		$no_garantii = $this->garantii_db->no_garantii($where_arr);
		$this->load->library('pagination');
		
		$config['base_url'] = site_url('utilizator/garantii');
		$config['total_rows'] = $no_garantii;
		$config['per_page'] = $this->per_page;
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-chevron-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 3;
		$config['num_links'] = 4;
		$this->pagination->initialize($config);
		
		$garantii = $this->garantii_db->garantii_join($where_arr, $order, $limits);
		
		$this->content['garantii'] = $garantii;
		$this->content['stare_garantie'] = $this->config->item('stare_garantie');
		//echo $this->db->last_query();
		$this->content['pages'] = $this->pagination->create_links();
		$this->content['no_garantii'] = $no_garantii;

		$this->layout['content'] = $this->load->view('utilizator/garantii', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function garantie(){
		check_logged();
		$id = $this->uri->segment(3);
		$garantie = $this->garantii_db->garantie(array('id' => $id, 'tert_id' => $this->session->userdata('tert_id')));
		if(!(is_array($garantie) and count($garantie))) {redirect('utilizator/garantii'); exit();}

		$this->load->model('magazin_db');
		$garantie['produs'] = $this->magazin_db->produs(array('id' => $garantie['produs_id']));

		$this->content['garantie'] = $garantie;
		$this->content['stare_garantie'] = $this->config->item('stare_garantie');
		$this->layout['content'] = $this->load->view('utilizator/garantie', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function adauga_garantie()
	{
		check_logged();
		$this->load->library(array('form_validation'));
		
		$this->form_validation->set_rules('tert', lang('tert'), 'trim');
		$this->form_validation->set_rules('cod_produs', lang('codprodus'), 'trim|required');
		$this->form_validation->set_rules('produs_id', lang('produsul'), 'trim');
		$this->form_validation->set_rules('bon_fiscal', lang('bon_fiscal'), 'trim|callback_bon_fiscal');
		$this->form_validation->set_rules('certificat', lang('certificat_de_garantie'), 'trim|callback_certificat');
		$this->form_validation->set_rules('observatie', lang('observatie'), 'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			$this->layout['content'] = $this->load->view('utilizator/adauga_garantie', $this->content, true);
			$this->load->view('layout', $this->layout);
		} else {
			$data = date('Y-m-d');
			$rec_garantie = array(
				'tert_id'		=> $this->session->userdata('tert_id'),
				'data'			=> $data,
				'stare'			=> 1, 
				'produs_id'		=> $this->input->post('produs_id'),
				'cod_produs'	=> $this->input->post('cod_produs'),
				'observatie'	=> $this->input->post('observatie')
				);
			$error = 0;
			$config['upload_path'] = $this->config->item('media_path')."garantii/";
			$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp|jpe';
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('bon_fiscal'))
			{
				$this->content['error_txt'] =  $this->upload->display_errors();
				$this->content['error'] = $this->load->view('error', $this->content, true);
				$error = 1;
			}
			else
			{
				$file_arr = $this->upload->data();
				$rec_garantie['bon_fiscal'] = $file_arr['file_name'];
			}

			if ( ! $this->upload->do_upload('certificat'))
			{
				$this->content['error_txt'] =  $this->upload->display_errors();
				$this->content['error'] = $this->load->view('error', $this->content, true);
				$error = 1;
			}
			else
			{
				$file_arr = $this->upload->data();
				$rec_garantie['certificat'] = $file_arr['file_name'];
			}
			
			if($error){
				$this->layout['content'] = $this->load->view('utilizator/adauga_garantie', $this->content, true);
				$this->load->view('layout', $this->layout);
			}
			else {
				$id = $this->garantii_db->adauga($rec_garantie);
				
				//$rec_todo = array(
				//	'user_id'		=> count($agent)?$agent['id']:16,
				//	'tert_id'		=> $this->session->userdata('tert_id'),
				//	'tip_id'		=> 3,
				//	'tip_info'		=> $id,
				//	'comanda_id'	=> 0,
				//	'data'			=> date('Y-m-d H:i:s'),
				//	'stare'			=> 0,
				//	'prioritate'	=> 3,
				//	'descriere'		=> 'Garantie'
				//	);
				//$this->magazin_db->adauga_to($rec_todo);
				
				redirect('utilizator/garantie/'.$id);
			}
		}
	}
	public function bon_fiscal()
	{
		if(!isset($_FILES['bon_fiscal']) || $_FILES['bon_fiscal']['error'] == UPLOAD_ERR_NO_FILE) {
		    $this->form_validation->set_message('bon_fiscal', 'Trebuie incarcat un bon fiscal.');
		    return FALSE;
		} else {
			$x = explode('.', $_FILES['bon_fiscal']['name']);
			$ext = end($x);
			if(!in_array($ext, array('gif','jpg','jpeg','png','bmp','jpe')))
			{
				$this->form_validation->set_message('bon_fiscal', 'Bon fiscal incarcat trebuie sa fie o imagine.');
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}
	public function certificat()
	{
		if(!isset($_FILES['certificat']) || $_FILES['certificat']['error'] == UPLOAD_ERR_NO_FILE) {
		    $this->form_validation->set_message('certificat', 'Trebuie incarcat un certificat de garantie.');
		    return FALSE;
		} else {
			$x = explode('.', $_FILES['certificat']['name']);
			$ext = end($x);
			if(!in_array($ext, array('gif','jpg','jpeg','png','bmp','jpe')))
			{
				$this->form_validation->set_message('certificat', 'Certificatul de garantie incarcat trebuie sa fie o imagine.');
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}
	/****************************/
	/* precomenzi				*/
	/****************************/
	function precomenzi(){
		check_logged();
		$where = array(
			'tert_id' 	=> $this->session->userdata('tert_id')
		);
		$precomenzi = $this->comenzi_db->precomenzi($where);
		foreach ($precomenzi as $k=>$p) {
			$precomenzi[$k]['produs'] = $this->magazin_db->produs_cu_imagine(array('id' => $p['produs_id']));
		}

		$this->content['precomenzi'] = $precomenzi;
		
		$this->layout['content'] = $this->load->view('utilizator/precomenzi', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function sterge_precomanda(){
		check_logged();
		$id = $this->input->post('id');
		$this->comenzi_db->sterge_precomanda(array('id' => $id));
	}
	
	
	function gdpr(){
		check_logged();
		$id = $this->session->userdata('id');;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('telefon', lang('telefon'), 'trim|required');
		$this->form_validation->set_rules('email', lang('email'), 'trim|valid_email|required');
		$this->form_validation->set_rules('delegat', lang('nume'), 'trim|required');
		$this->form_validation->set_rules('acord_date', lang('Acord date'), 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{

			$utilizator = $this->utilizator_db->utilizator(array('id' => $id));
			$this->content['error_txt'] = validation_errors();
			$this->content['error'] = $this->load->view('error', $this->content, true);
			$this->content['utilizator'] = $utilizator;

			$this->layout['content'] = $this->load->view('utilizator/gdpr', $this->content, true);
			$this->load->view('layout', $this->layout);
		} else {
			$rec = array(
				'telefon'			=> $this->input->post('telefon'),
				'email'				=> $this->input->post('email'),
				'delegat'			=> $this->input->post('delegat'),
				'data_actualizare'	=> date('Y-m-d H:i:s'),
				'gdpr'				=> 1,
				'ip_actualizare'	=> $_SERVER['REMOTE_ADDR'],
				);
			$this->utilizator_db->actualizeaza_utilizator($id, $rec);
			$this->session->set_userdata('gdpr', 1);
			
			$this->load->library('sendmachine', array('username' => '79e8dgc1hu1f6qonlk9poivn3w7ycjpj', 'password' => 't3s6j5800af604ulo3bdl71p39oftdzm'));
			$this->sendmachine->manage_contacts(6, [$this->input->post('email')], 'subscribe');
			redirect(site_url());
		}	
	}
	
	/********************/
	/* facturi			*/
	/********************/
	function facturi(){
		check_logged();
		
		$page = $this->uri->segment(3, 0);
		$data = $this->input->get('data');
		$stare = $this->input->get('stare');
		$numar = $this->input->get('numar');
		$sql_array = array();
		$where = array('tert_id' => $this->session->userdata('tert_id'));
		if($data!=''){
			$arr = explode("-", $data);
			$_data1 = str_replace("/", "-", $arr[0]);
			$_data1 = date('Y-m-d', strtotime($_data1));
			
			$_data2 = str_replace("/", "-", $arr[1]);
			$_data2 = date('Y-m-d', strtotime($_data2));
			
			$where['data >= '] = $_data1." 00:00:00";
			$where['data <= '] = $_data2." 23:59:59";
		}

		if($numar!=''){
			$sql_array[] = "CONCAT(serie,numar) LIKE '%".$numar."%'";
		}

		if($stare!=''){
			$where['stare'] = $stare;
		}
		$sql = implode(" and ", $sql_array);
		$limits = array('per_page' => $this->per_page, 'no' => $page);
		$facturi = $this->facturi_db->facturi($where, array('data'=>'desc', 'id'=>'desc'), $limits, $sql);
		foreach($facturi as $i=>&$f){
			$factura_continut = $this->facturi_db->continut(array('factura_id' => $f['id']));
			$total = 0;
			$valoare = 0;
			$platit = 0;
			foreach ($factura_continut as $cont) {
				$total +=$cont['total'];
				$valoare +=$cont['valoare'];
			}
			$plati_total = $this->facturi_db->plati(array('factura_id' => $f['id'], 'sters' => 0));
			foreach ($plati_total as $p) {
				$platit += $p['suma'];
			}

			$facturi[$i]['total'] = number_format($total, 2);
			$facturi[$i]['valoare'] = number_format($valoare, 2);
			$facturi[$i]['platit'] = number_format($platit,2);
		}
		$this->load->library('pagination');
		$config['base_url'] = site_url('utilizator/facturi/');
		$config['total_rows'] = $this->facturi_db->no_facturi($where,$sql);
		$config['per_page'] = $this->per_page;
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-chevron-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 3;
		$config['num_links'] = 4;
		$config['suffix'] = $_SERVER['QUERY_STRING']!='' ? "?".$_SERVER['QUERY_STRING']:'';
		$config['first_url'] = site_url('utilizator/facturi').$config['suffix'];
		$this->pagination->initialize($config);

		$stari = $this->stari_factura;
		
		$pages = $this->pagination->create_links();
		$this->content['pagini'] = $pages;
		$this->content['facturi'] = $facturi;
		$this->content['data'] = $data;
		$this->content['stare'] = $stare;
		$this->content['stari'] = array('' => 'Toate') + $stari;
		$this->content['numar'] = $numar;
		
		$this->layout['content'] = $this->load->view('utilizator/facturi', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function factura(){
		check_logged();
		$id = $this->uri->segment(3);
		$where = array(
			'id'		=> $id,
			'tert_id' 	=> $this->session->userdata('tert_id')
		);
		$factura = $this->facturi_db->factura($where);
		if(!(is_array($factura) and count($factura))) {redirect('utilizator/facturi'); exit();}
		$comanda = $this->comenzi_db->comanda(array('id' => $factura['comanda_id']));
		$tert = $this->utilizator_db->tert(array('id' => $factura['tert_id']));
		
		$adr = $this->utilizator_db->adrese_livrare(array('tert_id' => $factura['tert_id']));
		$adrese[''] = '';
		$judete = $this->config->item('judet');
		$tara = $this->config->item('tara');
		foreach ($adr as $a) {
			$adrese[$a['id']] = '';
			$adrese[$a['id']].= $tara[$a['tara']];
			if($a['tara']=='RO'){
				if($a['judet']!='')
					$adrese[$a['id']].= ', '.$judete[$a['judet']];
			} else {
				$adrese[$a['id']].= ', '.$a['judet'];
			}
			if($a['oras']!='')
				$adrese[$a['id']].= ', '.$a['oras'];

			$adrese[$a['id']].= ', '.$a['adresa'];
		}
		$modalitati_plata = array(''=>'') + $this->config->item('modalitati_plata');
		
		$this->content['factura_continut'] = $this->facturi_db->continut(array('factura_id' => $factura['id']));
		$this->content['factura'] = $factura;
		$this->content['tert'] = $tert;
		$this->content['comanda'] = $comanda;
		$this->content['adrese'] = $adrese;
		$this->content['stari'] = $this->stari_factura;
		$this->content['judete'] = $this->config->item('judet');
		$this->content['tara'] = $this->config->item('tara');
		$this->content['modalitati_plata'] = $modalitati_plata;
		
		$this->layout['content'] = $this->load->view('utilizator/factura', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function factura_excel(){
		check_logged();
		$id = $this->uri->segment(3);
		$where = array(
			'id'		=> $id,
			'tert_id' 	=> $this->session->userdata('tert_id')
		);
		$factura = $this->facturi_db->factura($where);
		if(!(is_array($factura) and count($factura))) {redirect('utilizator/facturi'); exit();}

		$comanda = $this->comenzi_db->comanda(array('id' => $factura['comanda_id']));
		$tert = $this->utilizator_db->tert(array('id' => $factura['tert_id']));
		
		$adr = $this->utilizator_db->adrese_livrare(array('tert_id' => $factura['tert_id']));
		$adrese[''] = '';
		$judete = $this->config->item('judet');
		$tara = $this->config->item('tara');
		foreach ($adr as $a) {
			$adrese[$a['id']] = '';
			$adrese[$a['id']].= $tara[$a['tara']];
			if($a['tara']=='RO'){
				if($a['judet']!='')
					$adrese[$a['id']].= ', '.$judete[$a['judet']];
			} else {
				$adrese[$a['id']].= ', '.$a['judet'];
			}
			if($a['oras']!='')
				$adrese[$a['id']].= ', '.$a['oras'];

			$adrese[$a['id']].= ', '.$a['adresa'];
		}
		$modalitati_plata = array(''=>'') + $this->config->item('modalitati_plata');
		
		$factura_continut = $this->facturi_db->continut(array('factura_id' => $factura['id']));
		$judete = $this->config->item('judet');
		$tara = $this->config->item('tara');
		$modalitati_plata = $modalitati_plata;
		
		$this->load->library('Phpexcel');
		$this->load->library('PHPExcel/Iofactory');
		$objPHPExcel = new Phpexcel();
		$objPHPExcel->getProperties()->setTitle("Factura")->setDescription('Factura');
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle("Factura");
		$k = 1;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$k, 'Factura');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$k, $factura['serie'].$factura['numar']);
		$k++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$k, 'Data (zi/luna/an)');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$k, date('d/m/Y', strtotime($factura['data'])));
		$k++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$k, 'Scadenta');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$k, date('d/m/Y', strtotime($factura['data_scadenta'])));
		$k++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$k, 'Nr. comanda');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$k, $factura['comanda_id']!=0?$factura['comanda_id']:'');
		$k++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$k, 'Data comanda');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$k, (is_array($comanda) and count($comanda))?date('d/m/Y', strtotime($comanda['data'])):'');
		$k++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$k, 'Moneda');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$k, $factura['moneda']);
		$k++;

		$k++;
		$k++;
		$k++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$k, 'Nr. crt.');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$k, 'Cod');
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$k, 'Denumirea produselor / serviciilor');
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$k, 'UM');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$k, 'Cantitate');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$k, "Pret Unitar\n");
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$k, "Valoare\n");
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$k, "TVA\n");
		$total = 0;
		$total_tva = 0;
		$k++;
		foreach($factura_continut as $i=>$cc){
			$total += round($cc['valoare'],2);
			$total_tva += round($cc['total'],2) - round($cc['valoare'],2);

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$k, $i+1);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$k, $cc['cod']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$k, $cc['articol']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$k, strtoupper($cc['um']));
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$k, number_format($cc['cantitate'],2));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$k, number_format(round($cc['pret_vanzare'],2),2));
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$k, number_format(round($cc['valoare'],2),2));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$k, number_format(round($cc['total'],2)-round($cc['valoare'],2),2));
			$k++;
		}
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objWriter = iofactory::createWriter($objPHPExcel, 'Excel5');
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
		//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// It will be called file.xls
		header('Content-Disposition: attachment; filename="factura.xls"');
		$objWriter->save('php://output');
	}
	
	function factura_pdf(){
		$id = $this->input->post('id');
		$factura = $this->facturi_db->factura(array('id' => $id));
		if(!(is_array($factura) and count($factura))) {redirect(site_url()); exit();}
		
		$factura_continut = $this->facturi_db->continut(array('factura_id' => $factura['id']));
		$comanda = $this->comenzi_db->comanda(array('id' => $factura['comanda_id']));
		$adresa_livrare = $this->utilizator_db->adresa_livrare(array('id' => $factura['tert_adresa_id']));
		$tert = $this->utilizator_db->tert(array('id' => $factura['tert_id']));
		
		$nr_telefoane = $this->utilizator_db->telefoane(array('tert_id' => $factura['tert_id']));
		$tel = array();
		if(is_array($nr_telefoane) and count($nr_telefoane))
			$tel[] = $nr_telefoane[0]['telefon'];

		if(is_array($comanda) and count($comanda))
		{
			$utilizator = $this->utilizator_db->utilizator(array('id' => $comanda['tert_utilizator_id']));	
			if(is_array($utilizator) and count($utilizator) and ($utilizator['telefon']!=''))
			{
				if(!in_array($utilizator['telefon'], $tel))
					$tel[] = $utilizator['telefon'];
			}
		}
		
		$tert['telefon'] = implode(",", $tel);

		$this->content['adresa_livrare'] = $adresa_livrare;
		$this->content['factura'] = $factura;
		$this->content['factura_continut'] = $factura_continut;
		$this->content['comanda'] = $comanda;
		$this->content['tert'] = $tert;
		if(is_array($comanda) and count($comanda))
			$this->content['curier'] = $this->curieri_db->curier(array('id' => $comanda['curier_id']));
			else $this->content['curier'] = array();
		$this->content['judete'] = $this->config->item('judet');
		$this->content['tara'] = $this->config->item('tara');
		$this->content['modalitati_plata'] = array('' => '') + $this->config->item('modalitati_plata');
		//$this->content['utilizator'] = $this->users_db->get(array('id' => $this->session->userdata('id')));
		$this->content['companie'] = $this->companii_db->get(array('id' => $factura['companie_id']));
		if($factura['tert_tara'] != 'RO'){
			$html = $this->load->view('utilizator/factura_pdf_en', $this->content, true);
		} else {
			$html = $this->load->view('utilizator/factura_pdf', $this->content, true);
		}
		// echo  $html;
		// exit();
		$this->load->library('WkHtmlToPdf');
		$pdf = new WkHtmlToPdf(array(
			'no-outline',         // Make Chrome not complain
			'margin-top'    => 10, //in mm
			'margin-right'  => 10,
			'margin-bottom' => 10,
			'margin-left'   => 10,
			// 'header-html' 	=> '<span>Header</span>',
			// 'footer-html' 	=> '<span>Footer</span>',

			// 'no-background'	=> false,
  	// 		'image' 		=> true
		));

		$pdf->addPage($html);
		
	   
		$file_name = $factura['serie'].$factura['numar'].'-'.$factura['tert_denumire'];
		$file_name_url = getcwd().'/media/facturi/'.url_title($file_name).".pdf";
		if(!$pdf->saveAs($file_name_url)) {
			die($pdf->getError());
		}
		echo url_title($file_name).".pdf";
	}
	
	function download_pdf(){
		$folder = $this->uri->segment(3);
		$file = $this->uri->segment(4);

		$file_name_url = getcwd().'/media/'.$folder.'/'.$file;
		
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		echo file_get_contents($file_name_url);
	}
}
