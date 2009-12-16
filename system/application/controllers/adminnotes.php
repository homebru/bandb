<?php
class AdminNotes extends Controller {

       function AdminNotes()
       {
            parent::Controller();

            $this->load->scaffolding('AdminNotes');
       }
}
?>
