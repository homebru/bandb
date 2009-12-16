<?php
class BE_Pages extends Controller {

       function BE_Pages()
       {
            parent::Controller();

            $this->load->scaffolding('be_Pages');
       }
}
?>
