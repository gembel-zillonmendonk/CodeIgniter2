<?php

class vw_ep_todo_persetujuan_kontrak extends MY_Model {

    public $table = 'VW_EP_TODO_PERSETUJUAN_KONTRAK';
    public $dir = 'contract';
    
    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>