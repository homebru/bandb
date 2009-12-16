<?php
class BE_PostCategory extends Controller {

       function BE_PostCategory()
       {
            parent::Controller();

            $this->load->scaffolding('be_PostCategory');
       }
}
?>
