<?
class Marketing extends MY_Controller
{
	var $layout, $content;
	function __construct()
	{
		parent::__construct();
		$this->subiect = 'Profita de Cupon-ul de 100lei. Verifica!';
	}
	
	function index() {
	}
	function trimite_vouchere() {
		$this->load->library('email');
		$config = Array(
				'protocol'  => 'smtp',
				'smtp_host' => $this->config->item('host_name'),
				'smtp_user' => $this->config->item('user_email'),
				'smtp_pass' => $this->config->item('password_email'),
				'mailtype'  => 'html',
				'newline'   => "\r\n"
			);
		
		$this->db->where(array('trimis' => 0));
		$vouchere = $this->db->get('vouchere_email')->result_array();

		$i = 0;
		$media_path = $_SERVER['DOCUMENT_ROOT'].'/media/';
		$img_path = $_SERVER['DOCUMENT_ROOT'].'/images/';
 		$img_url = base_url().'images/';
		
		foreach ($vouchere as $v) {
			$vinfo = $this->db->where(array('cod' => $v['cod']))->get('vouchere')->row_array();
			if(count($vinfo)){
				$this->email->clear(TRUE);

				$this->email->initialize($config);
				$this->email->from($this->config->item('from_email'), "Globiz");
				$this->email->reply_to($this->config->item('comenzi_email'), 'Globiz');
				//$this->email->attach($media_path.'marketing/voucher_reminder.jpg', 'inline');

				// $this->email->attach($img_path.'voucher_20180511/01.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/02.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/03.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/04.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/05.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/06.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/07.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/08.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/09.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/10.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/11.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/12.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/13.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/14.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/15.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/16.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/17.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/18.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/19.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/20.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/21.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/22.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/23.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/24.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/25.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/26.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/27.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/banner1.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/banner2.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/banner3.jpg', 'inline');
				// $this->email->attach($img_path.'voucher_20180511/banner4.jpg', 'inline');

				
				// $mesaj = "Stimate ".$v['nume']."<br />
				// <br />
				// Ne cerem scuze pentru incovenientele create legat de informarea modului de utilizare a voucheurului cadou,
				// din motive IT acesta nu s-a atasat.<br />
				// <br />
				// Vă mulțumim că vă numărați printre clienții firmei noastre și ca dovadă a faptului că sunteți important pentru 
				// noi vă oferim un voucher de cumpărături în valoare de 100 ron cu transport gratuit.<br />
				// <br />
				// Cod voucher: ".$v['cod']."<br />
				// Valabilitate: ".date('d/m/Y', strtotime($vinfo['data_expirare']))."<br />".
				// '<a href="http://www.globiz.ro">
				// 	<img src="cid:voucher_reminder.jpg" border="0" /><br />
				// </a>'.
				// "<br />
				// <br />
				// Cu multă stimă,<br />
				// Echipa Globiz";


				// $mesaj = "Stimate ".$v['nume'].",<br/>
				// <br />
				// Dorim sa va aducem aminte ca este ultima saptamana in care puteti utiliza codul de voucher ".$v['cod']."<br />
				// Voucherul este valabil pana la 28.02.2015<br />".
				// '<a href="http://www.globiz.ro">
				// 	<img src="cid:voucher_reminder.jpg" border="0" /><br />
				// </a>'.
				// "<br />
				// <br />
				// Cu multă stimă,<br />
				// Echipa Globiz";

				$mesaj = $this->load->view('marketing/newsletter', $v, true);

				$this->email->to($v['email'], $v['nume']);
				$this->email->subject($this->subiect);
				$this->email->message($mesaj);
				if($this->email->send()){
					//update voucher trimis
					//echo $this->email->print_debugger();
					$i++;
					echo $i.'. Voucher trimis la '.$v['email']."<br>\n";
					$this->db->where(array('id' => $v['id']))->limit(1)->update('vouchere_email', array('trimis' => 1)); 
				}
			}
		}
	}

	function test(){
		$v = array(
			'cod' => '58948FDDD5374',
            'email' => 'luci@solutiiweb.ro',
            'nume' => 'Luci'
			);
		$this->load->view('marketing/newsletter', $v);
	}

	function test_trimitere(){
		$this->load->library('email');
		$config = Array(
				'protocol'  => 'smtp',
				'smtp_host' => $this->config->item('host_name'),
				'smtp_user' => $this->config->item('user_email'),
				'smtp_pass' => $this->config->item('password_email'),
				'mailtype'  => 'html',
				'newline'   => "\r\n"
			);
		$i = 0;
		$vouchere[] = array(
			'cod' => '5E3BBD32DF273',
            'email' => 'gina@solutiiweb.ro',
            'nume' => 'Gina'
			);
		$vouchere[] = array(
			'cod' => '5E3BBD32E9FFA',
            'email' => 'luci@solutiiweb.ro',
            'nume' => 'Luci'
			);
		// $vouchere[] = array(
		// 	'cod' => '5D15CFD4366C6',
  //           'email' => 'ginaciocoiu@yahoo.com',
  //           'nume' => 'Gina'
		// 	);
		// $vouchere[] = array(
		//  	'cod' => '5D15CFD4366C6',
  //            'email' => 'ldumea@yahoo.com',
  //            'nume' => 'Luci'
		//  	);
		// $vouchere[] = array(
		// 	'cod' => '5D15CFD4366C6',
  //           'email' => 'iosif.budai@globiz.ro',
  //           'nume' => 'Iosif Budai'
		// 	);
		$img_path = $_SERVER['DOCUMENT_ROOT'].'/images/';
		foreach ($vouchere as $v) {
			$vinfo = $this->db->where(array('cod' => $v['cod']))->get('vouchere')->row_array();
			if(count($vinfo)){
				$this->email->clear(TRUE);

				$this->email->initialize($config);
				$this->email->from($this->config->item('from_email'), "Globiz");
				$this->email->reply_to($this->config->item('comenzi_email'), 'Globiz');
				//$this->email->attach($img_path.'voucher_20180511/img1.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img2.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img3.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img4.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img5.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img6.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img7.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img8.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img9.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img10.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img11.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img12.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img13.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img14.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img15.png', 'inline');
				//$this->email->attach($img_path.'voucher_20180511/img16.png', 'inline');
			
				$mesaj = $this->load->view('marketing/newsletter', $v, true);

				$this->email->to($v['email'], $v['nume']);
				$this->email->subject($this->subiect);
				$this->email->message($mesaj);
				if($this->email->send()){
					//update voucher trimis
					//echo $this->email->print_debugger();
					$i++;
					
					echo $i.'. Voucher trimis la '.$v['email'].'<br>';
					//$this->db->where(array('id' => $v['id']))->limit(1)->update('vouchere_email', array('trimis' => 1)); 
				} else {
					echo 'eroare trimitere';
				}
			} else {
				echo 'trimis';
			}
		}
	}
	function test_trimitere_janos(){
		$this->load->library('email');
		$config = Array(
				'protocol'  => 'smtp',
				'smtp_host' => $this->config->item('host_name'),
				'smtp_user' => $this->config->item('user_email'),
				'smtp_pass' => $this->config->item('password_email'),
				'mailtype'  => 'html',
				'newline'   => "\r\n"
			);
		$i = 0;
//		$vouchere[] = array(
//			'cod' => '5757C1B6BB4BE',
//            'email' => 'gina@solutiiweb.ro',
//            'nume' => 'Gina'
//			);
//		$vouchere[] = array(
//			'cod' => '5757C1B6BDF29',
//            'email' => 'luci@solutiiweb.ro',
//            'nume' => 'Luci'
//			);
//		$vouchere[] = array(
//			'cod' => '5757C1B6C0792',
//            'email' => 'ginaciocoiu@yahoo.com',
//            'nume' => 'Gina'
//			);
//		
		$vouchere[] = array(
			'cod' => '5C0510D628BA3',
            'email' => 'janos.budai@carguard.ro',
            'nume' => 'Janos Budai'
			);
		foreach ($vouchere as $v) {
			$vinfo = $this->db->where(array('cod' => $v['cod']))->get('vouchere')->row_array();
			if(count($vinfo)){
				$this->email->clear(TRUE);

				$this->email->initialize($config);
				$this->email->from($this->config->item('from_email'), "Globiz");
				$this->email->reply_to($this->config->item('comenzi_email'), 'Globiz');


				$mesaj = $this->load->view('marketing/newsletter', $v, true);

				$this->email->to($v['email'], $v['nume']);
				$this->email->subject($this->subiect);
				$this->email->message($mesaj);
				if($this->email->send()){
					//update voucher trimis
					//echo $this->email->print_debugger();
					$i++;
					echo $i.'. Voucher trimis la '.$v['email'].'<br>';
					//$this->db->where(array('id' => $v['id']))->limit(1)->update('vouchere_email', array('trimis' => 1)); 
				}
			}
		}
	}
}