<?
class Comenzi_db extends CI_Model
{
	function comenzi($rec = array(), $order = array(), $limits = array(), $sql = '')
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
		return $this->db->get('comenzi')->result_array();
	}
	function no_comenzi($where = array(), $sql = '')
	{
		$this->db->where($where);
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('comenzi')->num_rows();
	}
	function comanda($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('comenzi')->row_array();
	}
	function adauga($rec)
	{
		$this->db->insert('comenzi', $rec);
		return $this->db->insert_id();
	}
	function actualizeaza($id, $rec)
	{
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('comenzi', $rec); 
	}
	/****************************/
	/* comanda continut         */
	/****************************/
	function continut($rec = array())
	{
		$this->db->where($rec);
		$this->db->order_by('id', 'asc');
		return $this->db->get('comenzi_continut')->result_array();
	}
	function linie($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('comenzi_continut')->row_array();
	}
	function adauga_linie($rec)
	{
		$this->db->insert('comenzi_continut', $rec);
		return $this->db->insert_id();
	}


	
	function plati($rec = array(), $order = array(), $limits = array(), $sql = '')
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
		return $this->db->get('comenzi_plati')->result_array();
	}
	function adauga_plata($rec){
		$this->db->insert('comenzi_plati', $rec);
		return $this->db->insert_id();
	}
	function plata($rec, $order = array()){
		$this->db->where($rec);
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		return $this->db->get('comenzi_plati')->row_array();
	}
	/****************************/
	/* precomanda 		        */
	/****************************/
	function adauga_precomanda($rec){
		$this->db->insert('precomenzi', $rec);
		return $this->db->insert_id();
	}
	function precomanda($rec){
		$this->db->where($rec);
		return $this->db->get('precomenzi')->row_array();
	}
	function precomenzi($rec){
		$this->db->where($rec);
		return $this->db->get('precomenzi')->result_array();
	}
	function sterge_precomanda($rec){
		$this->db->delete('precomenzi', $rec);
	}
	
	/****************************/
	/* comenzi originale        */
	/****************************/
	
	function comanda_originala($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('comenzi_originale')->row_array();
	}
	function adauga_originala($rec)
	{
		$this->db->insert('comenzi_originale', $rec);
		return $this->db->insert_id();
	}
	function actualizeaza_originala($id, $rec)
	{
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('comenzi_originale', $rec); 
	}
	function sterge_continut_comanda_originala($rec){
		$this->db->delete('comenzi_originale_continut', $rec);
	}
	function adauga_continut_comanda_originala($rec)
	{
		$this->db->insert('comenzi_originale_continut', $rec);
		return $this->db->insert_id();
	}
}