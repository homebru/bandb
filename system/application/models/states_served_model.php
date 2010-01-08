<?php
class States_Served_Model extends Model {
	
	// Table Name
	private $tbl_states_served = 'StatesServed';


    function States_Served_Model()
    {
        // Call the Model constructor
        parent::Model();
    }
	
	function insert($detail)
	{
		$this->db->insert($this->tbl_states_served, $detail);
	}

	function delete_all($id)
	{
		$this->db->delete($this->tbl_states_served, array('BBDataID' => $id);
	}
}
?>