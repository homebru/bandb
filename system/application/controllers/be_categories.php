<?php
class BE_Categories extends Controller {

       function BE_Categories()
       {
            parent::Controller();

            $this->load->scaffolding('be_Categories');
       }
}
?>
