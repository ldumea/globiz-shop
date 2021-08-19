<?
class Garantii_db extends CI_Model
{
	function garantii($rec = array(), $order = array(), $limits = array(), $sql = '')
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
		return $this->db->get('garantii')->result_array();
	}
	function no_garantii($where = array(), $sql = '')
	{
		$this->db->where($where);
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('garantii')->num_rows();
	}

	function garantii_join($rec = array(), $order = array(), $limits = array(), $sql = '')
	{
		$this->db->select('garantii.*, terti.tip, terti.denumire, terti.nume, terti.prenume, terti.tip_document');
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
		$this->db->join('terti', 'terti.id = garantii.tert_id');
		return $this->db->get('garantii')->result_array();
	}
	function no_garantii_join($where = array(), $sql = '')
	{
		$this->db->select('garantii.*, terti.tip, terti.denumire, terti.nume, terti.prenume');
		$this->db->where($where);
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->join('terti', 'terti.id = garantii.tert_id');
		return $this->db->get('garantii')->num_rows();
	}
	function garantie($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('garantii')->row_array();
	}

	function adauga($rec)
	{
		$this->db->insert('garantii', $rec);
		return $this->db->insert_id();
	}

	function sterge($where = array())
	{
		$this->db->delete('garantii', $where);
	}
	function actualizeaza($id, $rec)
	{
		$this->db->where('id', $id);
		$this->db->limit(1);
		$this->db->update('garantii', $rec); 
	}
}