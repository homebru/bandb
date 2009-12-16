<?php
class BE_PostComment extends Controller {

       function BE_PostComment()
       {
            parent::Controller();

            $this->load->scaffolding('be_PostComment');
       }
}
?>
