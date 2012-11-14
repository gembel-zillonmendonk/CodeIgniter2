<?php

class vw_ep_todo_kontrak extends MY_Model {

    public $table = 'VW_EP_TODO_KONTRAK';
    public $dir = 'contract';
    
    function __construct() {
        parent::__construct();
        $this->init();
    }

}

?>