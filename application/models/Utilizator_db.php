<?
class Utilizator_db extends CI_Model
{
	function adauga($rec)
	{
		$this->db->insert('terti', $rec);
		return $this->db->insert_id();
	}
	function tert($rec, $sql = '')
	{
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->where($rec);
		return $this->db->get('terti')->row_array();
	}
	function actualizeaza($id, $rec)
	{
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('terti', $rec); 
	}
	function agent($rec = array()){
		$this->db->where($rec);
		$this->db->limit(1);
		return $this->db->get('users')->row_array();
	}
	function agent_judet($rec = array()){
		$this->db->where($rec);
		$this->db->limit(1);
		return $this->db->get('users_judete')->row_array();
	}
	/************************/
	/* adrese_livrare       */
	/************************/
	function adrese_livrare($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('terti_adrese_livrare')->result_array();
	}
	function adresa_livrare($rec)
	{
		$this->db->where($rec);
		return $this->db->get('terti_adrese_livrare')->row_array();
	}
	function adauga_adresa_livrare($rec)
	{
		$this->db->insert('terti_adrese_livrare', $rec);
		return $this->db->insert_id();
	}
	function actualizeaza_adresa_livrare($id, $rec)
	{
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('terti_adrese_livrare', $rec); 
	}
	function sterge_adresa_livrare($rec)
	{
		$this->db->delete('terti_adrese_livrare', $rec);
	}
	function localitati($rec = array(), $order = array()){
		$this->db->where($rec);
		foreach($order as $k=>$v)
		{
			$this->db->order_by($k, $v);
		}
		return $this->db->get('localitati')->result_array();
	}
	function localitate($rec){
		$this->db->where($rec);
		return $this->db->get('localitati')->row_array();
	}
	/************************/
	/* utilizatroi	       */
	/************************/
	function utilizatori($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('terti_utilizatori')->result_array();
	}
	function utilizator($rec)
	{
		$this->db->where($rec);
		return $this->db->get('terti_utilizatori')->row_array();
	}
	function adauga_utilizator($rec)
	{
		$this->db->insert('terti_utilizatori', $rec);
		return $this->db->insert_id();
	}
	function actualizeaza_utilizator($id, $rec)
	{
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('terti_utilizatori', $rec); 
	}
	function sterge_utilizator($rec)
	{
		$this->db->delete('terti_utilizatori', $rec);
	}
	
	function telefoane($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('terti_telefoane')->result_array();
	}


	function terti_emails($rec)
	{
		$this->db->where($rec);
		return $this->db->get('terti_email')->result_array();
	}
	function actualizeaza_terti_email($id, $rec)
	{
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('terti_email', $rec); 
	}
}