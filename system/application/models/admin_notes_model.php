<?php
class Admin_Notes_Model extends Model {
	
	// Table Name
	private $tbl_admin_notes = 'AdminNotes';


    function Admin_Notes_Model()
    {
        // Call the Model constructor
        parent::Model();
    }
	
	function update($id, $detail)
	{
		$this->db->where('UserID', $id);
		$this->db->update($this->tbl_admin_notes, $detail);
	}
}
?>