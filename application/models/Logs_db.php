<?
class Logs_db extends CI_Model
{
    function adauga($rec)
    {
        $this->db->insert('logs', $rec);
        return $this->db->insert_id();
    }
}