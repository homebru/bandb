<?php
class Classification extends Application {

       function Classification()
       {
            parent::Application();
			$this->auth->restrict('admin');

            $this->load->scaffolding('Classification');
       }
}
?>
