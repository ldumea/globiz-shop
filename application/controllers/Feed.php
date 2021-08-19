<?
class Feed extends MY_Controller
{
	var $layout, $content;
	function __construct()
	{
		parent::__construct();
		
		$this->per_page = 16;
		$this->load->model(array('utilizator_db'));
		$this->load->helper('text');
		ini_set('max_execution_time', 1200); 
		$this->coduri_eliminate = array('704', '709', '00033', '00022');
	}
	
	function index() {

	}
	function xml(){
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$this->load->helper('xml');
		$id = $this->uri->segment(3);
		$feed_hash = $this->uri->segment(4);

		$tert = $this->utilizator_db->tert(array('id' => $id, 'feed_hash' => $feed_hash));
		if(is_array($tert) and count($tert)){
			$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1)) AND cod NOT IN ('.implode(",", $this->coduri_eliminate).')';
			$articole = $this->magazin_db->produse(array('activ' => 1, 'magazin_id' => $this->config->item('shop_id')), array(), array(), $sql);
			// echo $this->db->last_query();exit();
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><articole/>');
			//$xml->addAttribute('')
			foreach ($articole as $key => $art) {
				$img = '';
				$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				if(is_array($imagine) and count($imagine))
					$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
					
				$imagini = $this->magazin_db->produse_imagini(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				
				//$img = '';
				//$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				//if(count($imagine))
				//	$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
				$categorii = $this->magazin_db->produs_categorii(array('articol_id' => $art['id']));
				$categorie = '';
				$path = array();
				foreach ($categorii as $c){
					$cat = $this->magazin_db->categorie(array('id' => $c['categorie_id']));
					if(is_array($cat) and count($cat)){
						if(count(explode("-", $cat['path'])) >= count($path)){
							$path = explode("-", $cat['path']);
							$path[] = $c['categorie_id'];
						}
						if($categorie =='')
							$categorie = $cat['nume'];
					}
				}
				
				$pathStr = '';
				$pathArr = array();
				foreach ($path as $p) {
					$cat = $this->magazin_db->categorie(array('id' => $p));
					if(is_array($cat) and count($cat)){
						if($cat['nume']=='Globiz')
							$pathArr[] = 'Home';
						else
							$pathArr[] = $cat['nume'];
					}
				}
				$pathStr = implode(" / ", $pathArr);
				
				$descriere = $art['descriere'];
				$descriere = convert_accented_characters($descriere);
				$descriere = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $descriere);
				$descriere = html_entity_decode($descriere, ENT_COMPAT, 'UTF-8');
				$descriere = xml_convert($descriere);

				//$descriere = str_replace($this->config->item('LATIN1_CHARS'), $this->config->item('LATIN2_CHARS'), $descriere);
				//$descriere = htmlspecialchars($descriere, ENT_QUOTES | ENT_XML1, 'UTF-8');
				//$descriere = htmlentities($descriere,ENT_COMPAT, 'UTF-8');
				
				$marca = $this->magazin_db->marca(array('id' => $art['marca_id']));
				$marca_text = isset($marca['marca'])?$marca['marca']:'';
				$denumire = $art['denumire'];
				$denumire = xml_convert($denumire);
				//$denumire = htmlentities($denumire,ENT_COMPAT, 'UTF-8');
				$pret = number_format($art['pret_vanzare'], 2);
				$pret_intreg = $pret;
				if ($art['pret_intreg'] > 0 && $art['pret_intreg'] != '' && $art['pret_vanzare'] < $art['pret_intreg']) {
					$pret_intreg = number_format($art['pret_intreg'],2);
				}

				
				
				$track = $xml->addChild('articol');
				$track->addChild('cod', $art['cod']);
				$track->addChild('denumire', $denumire);
				$track->addChild('descriere', $descriere);
				$track->addChild('pret', $pret);
				$track->addChild('imagine', $img);
				$track->addChild('marca', $marca_text);
				$track->addChild('cod_bare', $art['cod_bare']);
				$imagini_xml = $track->addChild('imagini');
				foreach($imagini as $imagine){
					$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
					$imagini_xml->addChild('imagine', $img);
				}
				$track->addChild('categorie', xml_convert($categorie));
				$track->addChild('caleCategorie', xml_convert($pathStr));
				$track->addChild('unitate_amabalare', $art['cantitate']);
				$track->addChild('um', $art['um']);
				if( ($art['stoc']==0) and ($art['stoc_furnizor']<15) and ($art['pret_furnizor']<2000)){
					$text = 'PRECOMANDA';
				} elseif( ($art['stoc']==0) and ($art['stoc_furnizor']==0) and ($art['furnizor_id']==1)){
					$text = 'PRECOMANDA';
				} elseif(($art['stoc']+$art['stoc_furnizor']==0) and ($art['precomanda']==1)) {
					$text = 'PRECOMANDA';
				} elseif($art['stoc']+$art['stoc_furnizor']<30){
					$text = 'STOC LIMITAT';
				} else{
					$text = 'IN STOC';
				}
				$track->addChild('stoc', $text);
				$track->addChild('pret_intreg', $pret_intreg);
				//if($key == 10) break;
			}
			//Header('Content-type: text/xml');
			header("Content-Type: text/xml; charset=utf-8");
			print($xml->asXML());

		}else redirect(site_url());
	}
	function csv(){
		$id = $this->uri->segment(3);
		$feed_hash = $this->uri->segment(4);
		
		$tert = $this->utilizator_db->tert(array('id' => $id, 'feed_hash' => $feed_hash));
		if(is_array($tert) and count($tert)){
			// $sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
			$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1)) AND cod NOT IN ('.implode(",", $this->coduri_eliminate).')';
			$articole = $this->magazin_db->produse(array('activ' => 1, 'magazin_id' => $this->config->item('shop_id')), array(), array(), $sql);

			// $articole = $this->magazin_db->produse(array('activ' => 1, 'magazin_id' => $this->config->item('shop_id')));
			$filename = "globiz.csv";
			header("Content-Type: text/csv; charset=utf-8");
			header( 'Content-Disposition: attachment;filename='.$filename);
			$out = fopen('php://output', 'w');
			foreach ($articole as $art) {
				$img = '';
				$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				if(is_array($imagine) and count($imagine))
					$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
				
				$img_galerie = '';
				$imagini = $this->magazin_db->produse_imagini(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				$_img = array();
				foreach($imagini as $imagine){
					$_img[] = $this->config->item('media_url').'articole/'.$imagine['imagine'];
				}
				if(is_array($_img) and count($_img)){
					$img_galerie = implode("|", $_img);
				}
				
				$categorii = $this->magazin_db->produs_categorii(array('articol_id' => $art['id']));
				$categorie = '';
				$path = array();
				foreach ($categorii as $c){
					$cat = $this->magazin_db->categorie(array('id' => $c['categorie_id']));
					if(is_array($cat) and count($cat)){
						if(count(explode("-", $cat['path'])) >= count($path)){
							$path = explode("-", $cat['path']);
							$path[] = $c['categorie_id'];
						}
						if($categorie =='')
							$categorie = $cat['nume'];
					}
				}
				$pathStr = '';
				$pathArr = array();
				foreach ($path as $p) {
					$cat = $this->magazin_db->categorie(array('id' => $p));
					if(is_array($cat) and count($cat)){
						if($cat['nume']=='Globiz')
							$pathArr[] = 'Home';
						else
							$pathArr[] = $cat['nume'];
					}
				}
				$pathStr = implode(" / ", $pathArr);

				if( ($art['stoc']==0) and ($art['stoc_furnizor']<15) and ($art['pret_furnizor']<2000)){
					$text = 'PRECOMANDA';
				} elseif( ($art['stoc']==0) and ($art['stoc_furnizor']==0) and ($art['furnizor_id']==1)){
					$text = 'PRECOMANDA';
				} elseif(($art['stoc']+$art['stoc_furnizor']==0) and ($art['precomanda']==1)) {
					$text = 'PRECOMANDA';
				} elseif($art['stoc']+$art['stoc_furnizor']<30){
					$text = 'STOC LIMITAT';
				} else{
					$text = 'IN STOC';
				}
				$marca = $this->magazin_db->marca(array('id' => $art['marca_id']));
				$marca_text = isset($marca['marca'])?$marca['marca']:'';
				$pret = number_format($art['pret_vanzare'], 2);
				$pret_intreg = $pret;
				if ($art['pret_intreg'] > 0 && $art['pret_intreg'] != '' && $art['pret_vanzare'] < $art['pret_intreg']) {
					$pret_intreg = number_format($art['pret_intreg'],2);
				}

				$arr = array(
					$art['cod'],
					$art['denumire'],
					$art['descriere'],
					$pret,
					$img,
					$categorie,
					$pathStr,
					$text,
					$img_galerie,
					$marca_text,
					$art['cod_bare'],
					$art['cantitate'],
					$art['um'],
					$pret_intreg
					);
				fputcsv($out, $arr);
			}
			
			fclose($out);

		}else redirect(site_url());
	}
	
	function csv2(){
		$id = $this->uri->segment(3);
		$feed_hash = $this->uri->segment(4);

		$tert = $this->utilizator_db->tert(array('id' => $id, 'feed_hash' => $feed_hash));
		if(is_array($tert) and count($tert)){
			$sql = 'cod NOT IN ('.implode(",", $this->coduri_eliminate).')';
			$articole = $this->magazin_db->produse(array('activ' => 1, 'magazin_id' => $this->config->item('shop_id')), array(), array(), $sql);
			// $articole = $this->magazin_db->produse(array('activ' => 1, 'magazin_id' => $this->config->item('shop_id')));
			$filename = "globiz.csv";
			header("Content-Type: text/csv; charset=utf-8");
			header( 'Content-Disposition: attachment;filename='.$filename);
			$out = fopen('php://output', 'w');
			foreach ($articole as $art) {
				$img = '';
				$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				if(is_array($imagine) and count($imagine))
					$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
					
				$img_galerie = '';
				$imagini = $this->magazin_db->produse_imagini(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				$_img = array();
				foreach($imagini as $imagine){
					$_img[] = $this->config->item('media_url').'articole/'.$imagine['imagine'];
				}
				if(is_array($_img) and count($_img)){
					$img_galerie = implode("|", $_img);
				}
				
				$categorii = $this->magazin_db->produs_categorii(array('articol_id' => $art['id']));
				$catArr = array();
				foreach ($categorii as $c) {
					$catArr[$c['id']] = $c['categorie_id'];
				}
				$marca = $this->magazin_db->marca(array('id' => $art['marca_id']));
				$marca_text = isset($marca['marca'])?$marca['marca']:'';
				$pathStr = '';
				$pathArr = array();
				foreach ($path as $p) {
					$cat = $this->magazin_db->categorie(array('id' => $p));
					if(is_array($cat) and count($cat)){
						if($cat['nume']=='Globiz')
							$pathArr[] = 'Home';
						else
							$pathArr[] = $cat['nume'];
					}
				}
				$pathStr = implode(" / ", $pathArr);
				$pret = number_format($art['pret_vanzare'], 2);
				$pret_intreg = $pret;
				if ($art['pret_intreg'] > 0 && $art['pret_intreg'] != '' && $art['pret_vanzare'] < $art['pret_intreg']) {
					$pret_intreg = number_format($art['pret_intreg'],2);
				}

				$arr = array(
					$art['cod'],
					$art['denumire'],
					$art['descriere'],
					$pret,
					$img,
					'"'.implode(",", $catArr).'"',
					$art['cantitate'],
					$img_galerie,
					$marca_text,
					$art['cod_bare'],
					$art['um'],
					$pathArr,
					$pret_intreg
					);
				fputcsv($out, $arr);
			}
			
			fclose($out);

		}else redirect(site_url());
	}
	
	function automavtech(){
		$id = $this->uri->segment(3);
		$feed_hash = $this->uri->segment(4);
		
		$tert = $this->utilizator_db->tert(array('id' => $id, 'feed_hash' => $feed_hash));
		if(is_array($tert) and count($tert)){
			$this->load->library('includes/Classes/phpexcel');
			$this->load->library('includes/Classes/PHPExcel/Writer/excel5');
			$this->load->library('includes/Classes/PHPExcel/Reader/Excel5_reader');
			$objPHPExcel = new PHPExcel();
			// Set properties
			$objPHPExcel->getProperties()->setCreator("Web Dedicated");
			$i = 0;
			// // Add some data
			$objPHPExcel->setActiveSheetIndex($i);
			$sheet = $objPHPExcel->getActiveSheet();
			$sheet = $objPHPExcel->getSheet($i);


			$num = 1;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$num, 'IMAGINE', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$num, 'DESCRIERE', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, 'PRODUCATOR (BRAND)', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$num, '', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, 'DENUMIRE', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$num, 'NR ARTICOL', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, 'ID', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$num, 'PRET', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$num, '(PRIORITATE)', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$num, 'CATEGORII', PHPExcel_Cell_DataType::TYPE_STRING);
			$num++;
			
			//$articole = $this->magazin_db->produse(array('activ' => 1, 'pret_vanzare_tva !='=> 0));
			$articole = $this->magazin_db->produse_categorie(array('activ' => 1, 'pret_vanzare_tva !='=> 0, 'articole_categorii.categorie_id' => 479, 'magazin_id' => $this->config->item('shop_id')));
			$filename = "globiz.xls";
			foreach ($articole as $art) {
				$img = '';
				$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				if(is_array($imagine) and count($imagine))
					$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$num, $img, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$num, strip_tags(br2nl($art['descriere'])), PHPExcel_Cell_DataType::TYPE_STRING);
				
				$categorii = $this->magazin_db->produs_categorii(array('articol_id' => $art['id']));
				$categorie = '';
				$path = array();
				foreach ($categorii as $c){
					$cat = $this->magazin_db->categorie(array('id' => $c['categorie_id']));
					if(is_array($cat) and count($cat)){
						if(count(explode("-", $cat['path'])) >= count($path)){
							$path = explode("-", $cat['path']);
							$path[] = $c['categorie_id'];
						}
						if($categorie =='')
							$categorie = $cat['nume'];
					}
				}
				$pathStr = '';
				$pathArr = array();
				foreach ($path as $p) {
					$cat = $this->magazin_db->categorie(array('id' => $p));
					if(is_array($cat) and count($cat)){
						if($cat['nume']=='Globiz')
							$pathArr[] = 'Home';
						else
							$pathArr[] = $cat['nume'];
					}
				}
				$pathStr = implode(" / ", $pathArr);
				
				
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $art['denumire'], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$num, $art['id'], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $art['cod'], PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$num, $art['pret_vanzare_tva'], PHPExcel_Cell_DataType::TYPE_STRING);
				$strat_letter = 'J';
				foreach($pathArr as $k=>$v){
					$coloana = chr(ord($strat_letter)+$k);
					$objPHPExcel->getActiveSheet()->SetCellValue($coloana.$num, $v, PHPExcel_Cell_DataType::TYPE_STRING);
				}
				
				$num++;
			}
			
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = new excel5($objPHPExcel);
			
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');
			// It will be called file.xls
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			// Write file to the browser
			$objWriter->save('php://output');
		}
	}
	
	function facebook(){
		$this->load->helper('text');
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename=facebook_globiz.csv');
		header('Pragma: no-cache');
		$conditie=array('activ' => '1', 'categorie_id !=' => '0', 'magazin_id'    => $this->config->item('shop_id'));
		$per_page=array();
		$pagina=array();
		$separator = ' | ';
		$manufacturer = '';
		$currency = 'RON';
		$sql = '';
		$sql = 'cod NOT IN ('.implode(",", $this->coduri_eliminate).')';

		// $selectie_categorii = array('6','897','8','824','4','13');
		// $cats = $this->maniac_db->articole_categorii($selectie_categorii);
		// foreach($cats as $v)
		// {
		//     $array[] = $v['articol_id'];
		// }
		// $cats = array_values($array);


		$produse = $this->magazin_db->produse($conditie, array(), array(), $sql);
		// echo $this->db->last_query();exit();
		$out = fopen('php://output', 'w');
		$header = array("id","availability","condition","description","product_type","image_link","link","title","price","sale_price","brand");
		fputcsv($out, $header);
		foreach ($produse as $key => $produs) {
			$manufacturer = 'Carguard';
			$cod_produs = '';
			$id_produs = '';
			$denumire = '';
			$descriere = '';
			$link = '';
			$img = '';
			$pret_produs = '';
			$shipping = '';
			$availability = 'in stock';
			$cod_bare = '';

			$categorii = array();
			$id_produs = $produs['id'];
			
			#imagini
			$imagini = $this->magazin_db->produse_imagini(array('articol_id' => $id_produs), array('ordine' => 'asc'));
			$produs['imagini'] = $imagini;
			if (isset($produs['imagini'][0]['imagine'])){
				$src = $this->config->item('media_url');
				$src.='articole/'.$produs['imagini'][0]['imagine'];
				$img = $this->config->item('timthumb_url').'?src='.$src.'&w=600&h=600&zc=2';
				

				#link
				$link_produs = produs_url($produs);
				$produs['link'] = $link_produs;
				
				#categorii
				$id_cat = $produs['categorie_id'];
				$sql = $this->magazin_db->produs_categorii(array('articol_id' => $produs['id']));
				if (isset($sql[0]['path'])) {
					$path = $sql[0]['path'];
					$path = explode('-', $path);
					$path[] = $sql[0]['id'];
					foreach ($path as $cat) {
						if ($cat != '294'){
							$categorie = $this->magazin_db->categorie(array('id' => $cat));
							$categorii[] = convert_accented_characters(html_entity_decode($categorie['nume']));
						}
					}
					$categorii = implode(" > ", $categorii);
				} else {
					$categorie = $this->magazin_db->categorie(array('id' => $id_cat));
					$categorii = convert_accented_characters(html_entity_decode($categorie['nume']));
				}
				
				
				$cod_produs = trim($produs['cod']);
				$denumire = clean_title(html_entity_decode($produs['denumire']));
				$produs['descriere'] =  html_entity_decode($produs['descriere']);
				if (isset($produs['descriere']) && $produs['descriere'] != '') {
					$descriere = clean_descr($produs['descriere']);
				}
				if (empty($descriere)){$descriere = $denumire;}
				
				$link = $produs['link'];
				$cod_bare = $produs['cod_bare'];
				
				if ($produs['pret_intreg'] > 0 && $produs['pret_intreg'] != '' && $produs['pret_vanzare'] < $produs['pret_intreg']) {
					$pret_produs = number_format($produs['pret_intreg'],2);
					$pret_promo_produs = number_format($produs['pret_vanzare'],2);
				} else {
					$pret_produs = number_format($produs['pret_vanzare'],2);
					$pret_promo_produs = "";
				}
				$prod_csv = array($id_produs,$availability,'new',$descriere,$categorii,$img,$link,$denumire,$pret_produs,$pret_promo_produs,$manufacturer);
				fputcsv($out, $prod_csv);
			}
		}
		fclose($out);
	}


	function csv_test(){
		$id = $this->uri->segment(3);
		$feed_hash = $this->uri->segment(4);

		// ini_set ( 'max_execution_time', 3600); 
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$tert = $this->utilizator_db->tert(array('id' => $id, 'feed_hash' => $feed_hash));
		if(is_array($tert) and count($tert)){

			$articole = $this->magazin_db->produse(array('activ' => 1, 'magazin_id' => $this->config->item('shop_id')));
			$filename = "globiz.csv";
			header("Content-Type: text/csv; charset=utf-8");
			header( 'Content-Disposition: attachment;filename='.$filename);
			$out = fopen('php://output', 'w');
			foreach ($articole as $k => $articol) {
				$img = '';
				$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $articol['id']), array('ordine' => 'asc'));
				if(is_array($imagine) and count($imagine))
					$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
				
				$img_galerie = '';
				$imagini = $this->magazin_db->produse_imagini(array('articol_id' => $articol['id']), array('ordine' => 'asc'));
				$_img = array();
				foreach($imagini as $imagine){
					$_img[] = $this->config->item('media_url').'articole/'.$imagine['imagine'];
				}
				if(is_array($_img) and count($_img)){
					$img_galerie = implode("|", $_img);
				}
				
				$categorii = $this->magazin_db->produs_categorii(array('articol_id' => $articol['id']));
				$categorie = '';
				$path = array();
				foreach ($categorii as $c){
					$cat = $this->magazin_db->categorie(array('id' => $c['categorie_id']));
					if(is_array($cat) and count($cat)){
						if(count(explode("-", $cat['path'])) >= count($path)){
							$path = explode("-", $cat['path']);
							$path[] = $c['categorie_id'];
						}
						if($categorie =='')
							$categorie = $cat['nume'];
					}
				}
				$pathStr = '';
				$pathArr = array();
				foreach ($path as $p) {
					$cat = $this->magazin_db->categorie(array('id' => $p));
					if(is_array($cat) and count($cat)){
						if($cat['nume']=='Globiz')
							$pathArr[] = 'Home';
						else
							$pathArr[] = $cat['nume'];
					}
				}
				$pathStr = implode(" / ", $pathArr);

				if( ($articol['stoc']==0) and ($articol['stoc_furnizor']<15) and ($articol['pret_furnizor']<2000)){
					$text = 'PRECOMANDA';
				} elseif( ($articol['stoc']==0) and ($articol['stoc_furnizor']==0) and ($articol['furnizor_id']==1)){
					$text = 'PRECOMANDA';
				} elseif(($articol['stoc']+$articol['stoc_furnizor']==0) and ($articol['precomanda']==1)) {
					$text = 'PRECOMANDA';
				} elseif($articol['stoc']+$articol['stoc_furnizor']<30){
					$text = 'STOC LIMITAT';
				} else{
					$text = 'IN STOC';
				}

				$arr = array(
					$articol['cod'],
					$articol['denumire'],
					$articol['descriere'],
					number_format($articol['pret_vanzare'], 2),
					$img,
					$categorie,
					$pathStr,
					$text,
					$img_galerie
					);
				fputcsv($out, $arr);
			}
			
			fclose($out);
		}else redirect(site_url());
	}
	
	
	function xml_materom(){
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$this->load->helper('xml');
		$id = $this->uri->segment(3);
		$feed_hash = $this->uri->segment(4);

		$tert = $this->utilizator_db->tert(array('id' => $id, 'feed_hash' => $feed_hash));
		if(is_array($tert) and count($tert)){
			$sql = '((articole.stoc > 0) OR (articole.stoc_furnizor > 0 ) OR (articole.furnizor_id = 1) OR (articole.precomanda = 1))';
			$articole = $this->magazin_db->produse(array('activ' => 1, 'magazin_id' => $this->config->item('shop_id'), 'materom_ok'=>1), array(), array(), $sql);

			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><articole/>');
			//$xml->addAttribute('')
			foreach ($articole as $key => $art) {
				$img = '';
				$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				if(is_array($imagine) and count($imagine))
					$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
					
				$imagini = $this->magazin_db->produse_imagini(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				
				//$img = '';
				//$imagine = $this->magazin_db->produse_imagine(array('articol_id' => $art['id']), array('ordine' => 'asc'));
				//if(count($imagine))
				//$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
				$categorii = $this->magazin_db->produs_categorii(array('articol_id' => $art['id']));
				$categorie = '';
				$path = array();
				foreach ($categorii as $c){
					$cat = $this->magazin_db->categorie(array('id' => $c['categorie_id']));
					if(is_array($cat) and count($cat)){
						if(count(explode("-", $cat['path'])) >= count($path)){
							$path = explode("-", $cat['path']);
							$path[] = $c['categorie_id'];
						}
						if($categorie =='')
							$categorie = $cat['nume'];
					}
				}
				
				$pathStr = '';
				$pathArr = array();
				foreach ($path as $p) {
					$cat = $this->magazin_db->categorie(array('id' => $p));
					if(is_array($cat) and count($cat)){
						if($cat['nume']=='Globiz')
							$pathArr[] = 'Home';
						else
							$pathArr[] = $cat['nume'];
					}
				}
				$categorie = end($pathArr);
				$pathStr = implode(" / ", $pathArr);
				$atribute_articol = $this->magazin_db->atribute_articol(array('articol_id' => $art['id']));
				$atribute = array();
				foreach ($atribute_articol as $aa) {
					$atribute[] = array(
						'atribut' => $this->magazin_db->atribut(array('id' => $aa['atribut_id'])),
						'valoare' => $this->magazin_db->valoare(array('id' => $aa['valoare_id'])),
						);
				}
				$descriere = $art['descriere'];
				$descriere = convert_accented_characters($descriere);
				$descriere = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $descriere);
				$descriere = html_entity_decode($descriere, ENT_COMPAT, 'UTF-8');
				$descriere = xml_convert($descriere);

				//$descriere = str_replace($this->config->item('LATIN1_CHARS'), $this->config->item('LATIN2_CHARS'), $descriere);
				//$descriere = htmlspecialchars($descriere, ENT_QUOTES | ENT_XML1, 'UTF-8');
				//$descriere = htmlentities($descriere,ENT_COMPAT, 'UTF-8');
				
				$denumire = $art['denumire'];
				$marca = $this->magazin_db->marca(array('id' => $art['marca_id']));
				
				$denumire = xml_convert($denumire);
				//$denumire = htmlentities($denumire,ENT_COMPAT, 'UTF-8');
				$pret = number_format(pret_mic_materom($tert, $art), 2);
				
				$track = $xml->addChild('articol');
				$track->addChild('cod', $art['cod']);
				$track->addChild('denumire', $denumire);
				$track->addChild('descriere', xml_convert($descriere));
				$track->addChild('marca', $marca['marca']);
				$track->addChild('pret', $pret);
				$track->addChild('imagine', $img);
				$imagini_xml = $track->addChild('imagini');
				foreach($imagini as $imagine){
					$img = $this->config->item('media_url').'articole/'.$imagine['imagine'];
					$imagini_xml->addChild('imagine', $img);
				}
				$track->addChild('categorie', xml_convert($categorie));
				$track->addChild('caleCategorie', xml_convert($pathStr));
				$track->addChild('unitate_amabalare', $art['cantitate']);
				$track->addChild('cantitate_cutie', $art['cantitate_cutie']);
				$track->addChild('um', $art['um']);
				if( ($art['stoc']==0) and ($art['stoc_furnizor']<15) and ($art['pret_furnizor']<2000)){
					$text = 'PRECOMANDA';
				} elseif( ($art['stoc']==0) and ($art['stoc_furnizor']==0) and ($art['furnizor_id']==1)){
					$text = 'PRECOMANDA';
				} elseif(($art['stoc']+$art['stoc_furnizor']==0) and ($art['precomanda']==1)) {
					$text = 'PRECOMANDA';
				} elseif($art['stoc']+$art['stoc_furnizor']<30){
					$text = 'STOC LIMITAT';
				} else{
					$text = 'IN STOC';
				}
				$track->addChild('stoc', $text);
				
				$atribute_xml = $track->addChild('caracteristici');
				foreach ($atribute as $atr) {
					if ($atr['valoare']){
						$atr_xml = $atribute_xml->addChild('caracteristica', xml_convert($atr['valoare']['valoare']));
						$atr_xml->addAttribute('nume', strtolower($atr['atribut']['atribut']));
					}
				}
				//if($key == 10) break;
			}
			//Header('Content-type: text/xml');
			header("Content-Type: text/xml; charset=utf-8");
			print($xml->asXML());

		}else redirect(site_url());
	}

	function test(){
		$id = $this->uri->segment(3);
		$feed_hash = $this->uri->segment(4);

		$articol = $this->magazin_db->produs(array('id' => $this->uri->segment(5)));
		// print_r($articol);

		$tert = $this->utilizator_db->tert(array('id' => $id, 'feed_hash' => $feed_hash));
		echo number_format(pret_mic_materom($tert, $articol),2);
	}

	
}