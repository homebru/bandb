<?php
class Profile_Model extends Model {
	
	// Table Name
	private $tbl_profile= 'ClientProfile';


    function Profile_Model()
    {
        // Call the Model constructor
        parent::Model();
    }
	
	function update($id, $profile)
	{
		$this->db->where('UserID', $id);
		$this->db->update($this->tbl_profile, $profile);
	}
}
?>