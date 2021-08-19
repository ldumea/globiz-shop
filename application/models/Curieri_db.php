<?
class Curieri_db extends CI_Model
{
	function curieri($rec = array(), $order = array(), $limits = array(), $sql = '')
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
		return $this->db->get('curieri')->result_array();
	}
	function curier($rec = array())
	{
		$this->db->where($rec);
		return $this->db->get('curieri')->row_array();
	}
}