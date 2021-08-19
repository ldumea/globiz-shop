<?php
class Schimbalimba
{
    function initializare() {
        $ci = get_instance();
		$ci->load->helper('cookie');
		$lang = $ci->input->cookie('language_frontend');

		if($lang == '')
		{
			$lang = 'ro';
			$cookie = array(
				'name'   => 'language_frontend',
				'value'  => $lang,
				'expire' => '86500'
				);
			$ci->input->set_cookie($cookie);
		}
		$ci->session->set_userdata('language_frontend', $lang);
		switch($lang)
		{
			case 'en':
				$ci->config->set_item('language', 'english');
				$ci->lang->load('globiz', 'english');
				$ci->session->set_userdata('fieldLang', '_en');
				$ci->session->set_userdata('folderView', 'en');
				break;
			default:
				$ci->config->set_item('language', 'romanian');
				$ci->lang->load('globiz', 'romanian');
				$ci->session->set_userdata('fieldLang', '');
				$ci->session->set_userdata('folderView', '');
				break;
		}
    }
}