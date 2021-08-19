<?
class Facturi_db extends CI_Model
{
	function facturi($rec = array(), $order = array(), $limits = array(), $sql = '')
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
		return $this->db->get('facturi')->result_array();
	}
	function no_facturi($where = array(), $sql = '')
	{
		$this->db->where($where);
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('facturi')->num_rows();
	}
	function factura($rec, $sql = '')
	{
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->where($rec);
		return $this->db->get('facturi')->row_array();
	}
	/****************************/
	/* continut factura			*/
	/****************************/
	function continut($rec = array())
	{
		$this->db->where($rec);
		$this->db->order_by('id', 'asc');
		return $this->db->get('facturi_continut')->result_array();
	}

	/****************************/
	/* plati factura			*/
	/****************************/
	function plati($rec = array())
	{
		$this->db->where($rec);
		$this->db->order_by('data', 'asc');
		return $this->db->get('facturi_plati')->result_array();
	}
	function plata($rec){
		$this->db->where($rec);
		return $this->db->get('facturi_plati')->row_array();
	}
}