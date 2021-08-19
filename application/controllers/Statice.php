<?
class Statice extends MY_Controller
{
	var $layout, $content;
	function __construct()
	{
		parent::__construct();
		
		$this->per_page = 16;
		$this->layout['javascript'][] =  base_url().THEMESFOLDER.'js/statice.js';
		$this->load->model('continut_db');
	}
	
	function index()
	{
		$uri = $this->uri->rsegment(3);
		
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/'.$uri, $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function contact()
	{
		$this->layout['current_page'] = 'contact';
		$this->layout['javascript'][] = "https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false";
		$this->layout['javascript'][] = base_url().THEMESFOLDER.'js/contact.js';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/contact', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function contact_send()
	{
		$this->load->library('form_validation');      
		$this->form_validation->set_rules('nume', 'Nume', 'trim|required');                    
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');      
		$this->form_validation->set_rules('subiect', 'Subiect', 'trim|required');        
		$this->form_validation->set_rules('mesaj', 'Mesaj', 'trim|required');        

		if ($this->form_validation->run() == FALSE)
		{
		  $data['errors'] = validation_errors();            
		  echo json_encode($data);
		}
		else
		{ 
		  $mesaj = '
		            <style>
		            body, table, td {
		              font-family: Verdana, Arial;
		              font-size: 12px;
		              color: #888888;
		            }
		            </style>
		            <table border="0" cellspacing="2" cellpadding="2">
		            <tr>
		              <td colspan="2"><strong>Contact</strong></td>
		            </tr>
		            <tr>
		              <td>Nume:</td>
		              <td>'.$this->input->post('nume').'</td>
		            </tr>
		            <tr>
		              <td>Email:</td>
		              <td>'.$this->input->post('email').'</td>
		            </tr>
		             <tr>
		              <td>Subiect:</td>
		              <td>'.$this->input->post('subiect').'</td>
		            </tr>
		            <tr>
		              <td>Mesaj:</td>
		              <td>'.$this->input->post('mesaj').'</td>
		            </tr>
		            </table>';
		  
		  $subiect = 'Pagina Contact: ' . $this->input->post('subiect');

		  $config['protocol'] = 'smtp';
		  $config['smtp_host'] = $this->config->item('host_name');
		  $config['smtp_user'] = $this->config->item('user_email');
		  $config['smtp_pass'] = $this->config->item('password_email');
		  $config['mailtype'] = 'html';

		  $this->load->library('email');
		  $this->email->clear();
		  $this->email->initialize($config);
		  $this->email->to($this->config->item('from_email'));
		  $this->email->from($this->input->post('email'), $this->input->post('nume'));
		  $this->email->subject($subiect);
		  $this->email->message($mesaj);
		  $this->email->send();		  
		  
		  $data['succes'] = 'Mesajul dvs. a fost trimis. Va multumim.';
		  echo json_encode($data);                     
		}
	}
	function pagina(){
		$id = $this->uri->rsegment(3);
		$pagina = $this->continut_db->pagina(array('id' => $id));
		$this->content['pagina'] = $pagina;
		$this->layout['title'] = $pagina['titlu'];
		$this->displayPage('statice/pagina');
	}
	function despre_noi()
	{
		$this->layout['large'] = true;
		$this->layout['title'] = 'Despre noi';
		$this->displayPage('statice/'.$this->session->userdata('folderView').'/despre_noi');
	}

	function departament_managerial(){
		$this->layout['current_page'] = 'contact';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/departament_managerial', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function departament_contabilitate(){
		$this->layout['current_page'] = 'contact';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/departament_contabilitate', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function departament_vanzari(){
		$this->layout['current_page'] = 'contact';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/departament_vanzari', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function garanti(){
		$this->layout['current_page'] = 'contact';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/garanti', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function suport_tehnic(){
		$this->layout['current_page'] = 'contact';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/suport_tehnic', $this->content, true);
		$this->load->view('layout', $this->layout);
	}

	function de_ce_noi(){
		$id = $this->uri->rsegment(3);
		
		$this->content['pagina'] = $this->continut_db->pagina(array('id' => $id));
		$this->layout['current_page'] = 'de_ce_noi';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/de_ce_noi', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	
	function clientii_nostrii(){
		$this->layout['current_page'] = 'clienti';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/clientii_nostrii', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	
	function beneficii(){
		$uri = $this->uri->rsegment(3);
		
		$this->content['uri'] = $uri;
		
		$this->layout['current_page'] = 'de_ce_noi';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/beneficii/'.$uri, $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function cariera(){
		$this->layout['current_page'] = 'cariera';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/cariera', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function evenimente(){
		$this->layout['current_page'] = 'stiri';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/evenimente', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function pareri(){
		$this->layout['current_page'] = 'stiri';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/pareri', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function program_sarbatori(){
		$this->layout['current_page'] = 'stiri';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/program_sarbatori', $this->content, true);
		$this->load->view('layout', $this->layout);
	}

	function gdpr(){
		$this->layout['current_page'] = 'stiri';
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/gdpr', $this->content, true);
		$this->load->view('layout', $this->layout);
	}

	function dezabonare(){
		$this->load->model('utilizator_db');
		$email = $this->uri->rsegment(3);
		$_emails = $this->utilizator_db->terti_emails(array('email' => $email));
		foreach ($_emails as $e) {
			$this->utilizator_db->actualizeaza_terti_email($e['id'], array('dezabonat' => 1));
		}
		$_emails = $this->utilizator_db->utilizatori(array('email' => $email));
		foreach ($_emails as $e) {
			$this->utilizator_db->actualizeaza_utilizator($e['id'], array('dezabonat' => 1));
		}
		$this->content['email'] = $email;
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/dezabonare', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
	function reabonare(){
		$email = $this->uri->rsegment(3);
		$_emails = $this->utilizator_db->terti_emails(array('email' => $email));
		foreach ($_emails as $e) {
			$this->utilizator_db->actualizeaza_terti_email($e['id'], array('dezabonat' => 0));
		}
		$_emails = $this->utilizator_db->utilizatori(array('email' => $email));
		foreach ($_emails as $e) {
			$this->utilizator_db->actualizeaza_utilizator($e['id'], array('dezabonat' => 0));
		}
		$this->content['email'] = $email;
		$this->layout['content'] = $this->load->view('statice/'.$this->session->userdata('folderView').'/reabonare', $this->content, true);
		$this->load->view('layout', $this->layout);
	}
}