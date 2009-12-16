<?php
class BE_Posts extends Controller {

       function BE_Posts()
       {
            parent::Controller();

            $this->load->scaffolding('be_Posts');
       }
}
?>
