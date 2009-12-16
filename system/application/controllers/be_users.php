<?php
class BE_Users extends Controller {

       function BE_Users()
       {
            parent::Controller();

            $this->load->scaffolding('be_Users');
       }
}
?>
