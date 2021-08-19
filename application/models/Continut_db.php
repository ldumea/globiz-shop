<?
class Continut_db extends CI_Model
{
	function pagini($rec = array(), $order = array(), $limits = array(), $sql = '')
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
		return $this->db->get('pagini')->result_array();
	}
	function no_pagini($where = array(), $sql = '')
	{
		$this->db->where($where);
		if($sql != '') {
			$this->db->where($sql);
		}
		return $this->db->get('pagini')->num_rows();
	}
	function pagina($rec, $sql = '') {
		if($sql != '') {
			$this->db->where($sql);
		}
		$this->db->where($rec);
		return $this->db->get('pagini')->row_array();
	}
}