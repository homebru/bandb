<?php
class LinkType extends Application {

       function LinkType()
       {
            parent::Application();
			$this->auth->restrict('admin');

            $this->load->scaffolding('LinkType');
       }
}
?>
