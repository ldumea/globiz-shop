<?
class Magazin_db extends CI_Model
{
	function cataloage($rec = array(), $order = array(), $limits = array(), $sql = '')
	{
		$this->db->where($rec);
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		if(count($limits))
		{
			$this->db->limit($limits['per_page'], $limits['no']);
		}
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('cataloage')->result_array();
	}
	function catalog($rec, $sql = '') {
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->where($rec);
		return $this->db->get('cataloage')->row_array();
	}
	function categorii($rec = array(), $order = array(), $limits = array(), $sql = '')
	{
		$this->db->where($rec);
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		if(count($limits))
		{
			$this->db->limit($limits['per_page'], $limits['no']);
		}
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('categorii')->result_array();
	}
	function categorie($rec, $sql = '')
	{
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->where($rec);
		return $this->db->get('categorii')->row_array();
	}
	function no_categorii($rec = array(), $sql = '')
	{
		$this->db->where($rec);
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('categorii')->num_rows();
	}
	function produse($rec = array(), $order = array(), $limits = array(), $sql = '' )
	{
		$this->db->where($rec);
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		if(count($limits))
		{
			$this->db->limit($limits['per_page'], $limits['no']);
		}
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('articole')->result_array();
	}
	function produse_categorie($rec = array(), $order = array(), $limits = array(), $sql = '' )
	{
		$this->db->where($rec);
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		if(count($limits))
		{
			$this->db->limit($limits['per_page'], $limits['no']);
		}
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->join('articole_categorii', 'articole.id = articole_categorii.articol_id', 'inner');
		$this->db->select("if (((articole.stoc+articole.stoc_furnizor) <= 0 OR (articole.stoc = 0 and articole.stoc_furnizor<15 and articole.pret_furnizor<2000) OR ((articole.stoc+articole.stoc_furnizor) <= 0) and articole.precomanda = 1), '1', '0' ) as produs_precomandabil, articole.*",false);
		return $this->db->get('articole')->result_array();
	}
	function no_produse_categorie($rec = array(), $sql = '' )
	{
		$this->db->where($rec);
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->join('articole_categorii', 'articole.id = articole_categorii.articol_id', 'inner');
		$this->db->select('articole.*');
		return $this->db->get('articole')->num_rows();
	}
	function produs($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('articole')->row_array();
	}
	function resigilat($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('articole_resigilate')->row_array();
	}
	function produs_cu_imagine($rec = array())
	{
		$this->db->where($rec);
		$articol = $this->db->get('articole')->row_array();
		$articol['imagine'] = $this->produse_imagine(array('articol_id' => $rec['id']), array('ordine' => 'asc'));
		return $articol;
	}
	function produse_imagine($rec, $order = array(), $sql = '')
	{
		if($sql != '') {
			$this->db->where($sql);
		}
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		$this->db->where($rec);
		return $this->db->get('articole_imagini')->row_array();
	}
	function produse_imagini($rec, $order = array(), $sql = '')
	{
		if($sql != '') {
			$this->db->where($sql);
		}
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		$this->db->where($rec);
		return $this->db->get('articole_imagini')->result_array();
	}
	function produse_imagini360($rec, $order = array(), $sql = '')
	{
		if($sql != '') {
			$this->db->where($sql);
		}
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		$this->db->where($rec);
		return $this->db->get('articole_imagini360')->result_array();
	}
	function actualizeaza_stoc_produs($id, $stoc_blocat){
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->set('stoc', 'stoc-'.$stoc_blocat, FALSE);
		$this->db->update('articole'); 
	}
	function adauga_stoc_blocat($rec){
		$this->db->insert('articole_stocuri_blocate', $rec);
		return $this->db->insert_id();
	}
	
	function articol_grup($rec)
	{
		$this->db->where($rec);
		return $this->db->get('articole_grupuri')->row_array();
	}
	function articole_grup($rec)
	{
		$this->db->where($rec);
		return $this->db->get('articole_grupuri')->result_array();
	}
	function dicounturi_grup($rec){
		$this->db->where($rec);
		$this->db->order_by('no_produse', 'asc');
		return $this->db->get('grupuri_plafoane')->result_array();
	}
	function discount_grup($rec){
		$this->db->where($rec);
		$this->db->order_by('discount', 'desc');
		return $this->db->get('grupuri_plafoane')->row_array();
	}
	
	function plafoane_reducere_generale(){
		$this->db->order_by('no_produse', 'asc');
		return $this->db->get('plafoane_reducere')->result_array();
	}
	function plafoan_reducere_general($rec = array()){
		$this->db->where($rec);
		$this->db->order_by('no_produse', 'desc');
		return $this->db->get('plafoane_reducere')->row_array();
	}

	function plafoane_reducere_individuale($rec){
		$this->db->where($rec);
		$this->db->order_by('no_produse', 'asc');
		return $this->db->get('articole_plafoane_reducere')->result_array();
	}
	function plafoan_reducere_individual($rec){
		$this->db->where($rec);
		$this->db->order_by('no_produse', 'desc');
		return $this->db->get('articole_plafoane_reducere')->row_array();
	}
	
	function slideshow($rec = array(), $order = array())
	{
		$this->db->where($rec);
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		return $this->db->get('slider')->result_array();
	}

	function produs_locatii($rec = array()){
		$this->db->where($rec);
		return $this->db->get('articole_locatii')->result_array();
	}
	function produs_locatie($rec = array()){
		$this->db->where($rec);
		return $this->db->get('articole_locatii')->row_array();
	}
	function produs_categorii($rec) {
		$this->db->where($rec);
		return $this->db->get('articole_categorii')->result_array();
	}
	function companie($rec, $sql = '')
    {
        if($sql != '') {
            $this->db->where($sql);
        }
        $this->db->where($rec);
        return $this->db->get('companii')->row_array();
    }
	/********************/
	/* vouchere			*/
	/********************/
	function voucher($rec = array()){
		$this->db->where($rec);
		return $this->db->get('vouchere')->row_array();
	}
	function actualizeaza_voucher($id, $rec){
		$this->db->where('id', $id);
		$this->db->update('vouchere', $rec); 
	}
	function voucher_utilizat($rec = array()){
		$this->db->where($rec);
		return $this->db->get('vouchere_utilizate')->row_array();
	}
	function adauga_voucher_utilizat($rec){
		$this->db->insert('vouchere_utilizate', $rec);
		return $this->db->insert_id();
	}

	function adauga_to($rec){
		$this->db->insert('todo', $rec);
		return $this->db->insert_id();
	}
	function adauga_to_obs($rec){
		$this->db->insert('todo_observatii', $rec);
		return $this->db->insert_id();
	}
	/********************/
	/* atribute			*/
	/********************/
	function atribute($rec = array(), $order = array(), $limits = array(), $sql = ''){
		$this->db->where($rec);
		foreach($order as $k=>$v){
			$this->db->order_by($k, $v);
		}
		if(count($limits)){
			$this->db->limit($limits['per_page'], $limits['no']);
		}
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('atribute')->result_array();
	}
	function atribut($rec, $order = array(), $sql = ''){
		if($sql != '') {
			$this->db->where($sql);
		}
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		$this->db->where($rec);
		return $this->db->get('atribute')->row_array();
	}
	function valori($rec = array(), $order = array(), $limits = array(), $sql = ''){
		$this->db->where($rec);
		foreach($order as $k=>$v){
			$this->db->order_by($k, $v);
		}
		if(count($limits)){
			$this->db->limit($limits['per_page'], $limits['no']);
		}
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('atribute_valori')->result_array();
	}
	function valoare($rec, $order = array(), $sql = ''){
		if($sql != '') {
			$this->db->where($sql);
		}
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		$this->db->where($rec);
		return $this->db->get('atribute_valori')->row_array();
	}
	function atribute_categorie($rec, $order = array(), $sql = '')
	{
		$this->db->select('atribute.*');
		$this->db->distinct();
		if($sql != '') {
			$this->db->where($sql);
		}
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		$this->db->where($rec);
		$this->db->join('atribute', 'atribute.id = categorii_atribute.atribut_id', 'join');
		$_filtre = $this->db->get('categorii_atribute')->result_array();
		$filtre = array();
		foreach ($_filtre as $key => $value) {
			$filtre[$value['id']]['atribut'] = $value['atribut'];
		}
		return $filtre;
	}
	function atribute_articol($rec){
		$this->db->where($rec);
		return $this->db->get('articole_atribute')->result_array();
	}
	function atribute_articole_categorie($rec, $order = array(), $sql = ''){
		$this->db->select('atribute.*');
		$this->db->distinct();
		if($sql != '') {
			$this->db->where($sql);
		}
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		$this->db->where($rec);
		$this->db->join('atribute', 'atribute.id = categorii_atribute.atribut_id', 'join');
		$_filtre = $this->db->get('categorii_atribute')->result_array();
		$filtre = array();
		foreach ($_filtre as $key => $value) {
			$filtre[$value['id']]['atribut'] = $value['atribut'];
			$sql = '
				SELECT DISTINCT atribute_valori.* 
				FROM articole_atribute 
				INNER JOIN atribute_valori ON atribute_valori.id = articole_atribute.valoare_id
				WHERE articole_atribute.atribut_id = '.$value['id'].' 
				ORDER BY atribute_valori.ordine
			';
			$valori = $this->db->query($sql)->result_array();
			foreach ($valori as $val) {
				$filtre[$value['id']]['valori'][$val['id']] = $val['valoare'];
			}
			//$this->db->get('atribute_valori')->result_array();
		}

		return $filtre;

	}
	
	function articole_complementare($rec, $sql, $order = array(), $limits = array())
	{
		$this->db->select('articole.*');
		$this->db->distinct();
		$this->db->where($rec);
		$this->db->join('articole', 'articole.id = articole_complementare.articol_id_complementar', 'inner');
		if($sql != '') {
			$this->db->where($sql);
		}
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		if(count($limits))
		{
			$this->db->limit($limits['per_page'], $limits['no']);
		}
		return $this->db->get('articole_complementare')->result_array();
	}
	
	
	function marca($rec, $sql = '')
	{
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->where($rec);
		return $this->db->get('marci')->row_array();
	}
	
	function produse_cautare($rec = array(), $order = array(), $limits = array(), $sql = '', $join = array(), $text = '')
	{
		if($text!=''){
			 $this->db->select('articole_cautare.*, MATCH(denumire, cod, descriere) AGAINST("'.$text.'" IN NATURAL LANGUAGE MODE) AS relevance');
		}
		$this->db->where($rec);
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		if(count($limits))
		{
			$this->db->limit($limits['per_page'], $limits['no']);
		}
		if($sql != '') {
			$this->db->where($sql);
		}
		if(count($join))
		{
			foreach($join as $tabel=>$j){
				$this->db->join($tabel, $j['conditie'], $j['tip']);
				if($j['select']!='')
					$this->db->select($j['select']);
			}
		}
		return $this->db->get('articole_cautare')->result_array();
	}
	function produse_cautare_query($query, $order = array(), $limits = array()){
		return $this->db->query($query)->result_array();
	}
    function total_produse_cautare($query){
    	return $this->db->query($query)->num_rows();
    }
	
	function pret_special($rec, $sql = '')
	{
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->where($rec);
		return $this->db->get('articole_preturi_speciale')->row_array();
	}
}