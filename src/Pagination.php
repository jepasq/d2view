<?php

class Pagination {
    public
    $current_page;
    
    function __construct($list, $result_per_page, $start_page=0){
        $this->current_page = $start_page;
    }
    
    };
?>
