<?
class Export extends MY_Controller
{
	var $layout, $content;
	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		$this->produse();
	}
	function produse(){
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=export_carguard.csv');
		$file = "php://output";
		$fp = fopen($file, 'w');
		$line = array('COD', 'DENUMIRE');
		fputcsv($fp, $line);
		
		$produse = $this->magazin_db->produse();
		foreach($produse as $p)
		{
			$line = array($p['cod'], $p['denumire']);
			fputcsv($fp, $line);
		}
		fclose($fp);
	}
}