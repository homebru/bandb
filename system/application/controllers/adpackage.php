<?php
class AdPackage extends Application {

       function AdPackage()
       {
            parent::Application();
			$this->auth->restrict('admin');

            $this->load->scaffolding('AdPackage');
       }
}
?>
