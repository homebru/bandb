<?php
class Bbdata extends Model {

    function Bbdata()
    {
        // Call the Model constructor
        parent::Model();
    }
	
	function get_website($website)
	{
		$query = $this->db->query ( 'SELECT WebsiteText
							FROM BBData
							WHERE BBData.Enabled = 1 AND BBData.WebsiteText LIKE \''.$this->db->escape_like_str($website).'%\'');
		$row = $query->row();
		if ($query->num_rows() > 0)
		{
		//gets the first row of the resulting dataset.  In this case, only 1 row will ever be returned
		   $results['record']['WebsiteText'] = $row->WebsiteText;
		   return $results;
		}
		else
			return $website;
	}
}
?>