<?
if($this->agent->is_mobile()){
	$this->load->view('mobil/cos/continut');
} else {
	$this->load->view('cos/continut');
}
?>