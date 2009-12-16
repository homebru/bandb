<?php
class BE_Roles extends Controller {

       function BE_Roles()
       {
            parent::Controller();

            $this->load->scaffolding('be_Roles');
       }
}
?>
