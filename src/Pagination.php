<?php

class Pagination {
    public
    $current_page,
    $rpp;
    
    function __construct($list, $result_per_page=100, $start_page=0){
        $this->current_page = $start_page;
        $this->rpp = $result_per_page;
    }
    
    };
?>
