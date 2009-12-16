<?php
class BE_UserRoles extends Controller {

       function BE_UserRoles()
       {
            parent::Controller();

            $this->load->scaffolding('be_UserRoles');
       }
}
?>
