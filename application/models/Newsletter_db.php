<?
class Newsletter_db extends CI_Model
{
	function newsletter($rec, $sql = '')
	{
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->where($rec);
		return $this->db->get('newsletters')->row_array();
	}
	function continut($rec = array(), $order = array(), $limits = array(), $sql = '')
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
		return $this->db->get('newsletters_continut')->result_array();
	}
	
}