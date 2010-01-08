<?php
class EditMethod extends Application {

       function EditMethod()
       {
            parent::Application();
			$this->auth->restrict('admin');

            $this->load->scaffolding('EditMethod');
       }
}
?>
