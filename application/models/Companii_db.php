<?
class Companii_db extends CI_Model
{
	function insert($rec)
    {
        $this->db->insert('companii', $rec);
        return $this->db->insert_id();
    }
    function get($rec, $sql = '')
    {
        if($sql != '') {
            $this->db->where($sql);
        }
        $this->db->where($rec);
        return $this->db->get('companii')->row_array();
    }
    function update($id, $rec)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->update('companii', $rec); 
    }

    function magazin_companie($rec, $sql = '')
    {
        if($sql != '') {
            $this->db->where($sql);
        }
        $this->db->where($rec);
        return $this->db->get('magazine_companii')->row_array();
    }
}