<?php
class Processor extends Application {

       function Processor()
       {
            parent::Application();
			$this->auth->restrict('admin');

            $this->load->scaffolding('Processor');
       }
}
?>
