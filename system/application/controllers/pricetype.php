<?php
class PriceType extends Application {

       function PriceType()
       {
            parent::Application();
			$this->auth->restrict('admin');

            $this->load->scaffolding('PriceType');
       }
}
?>
