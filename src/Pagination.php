<?php

class Pagination {
    public
    $current_page,
    $list,
    $rpp;   // Result per page

    /** The Pagination constructor
     *
     */
    function __construct($list, $result_per_page=100, $start_page=0){
        $this->current_page = $start_page;
        $this->rpp = $result_per_page;

        if (!is_array($list)) {
            $msg="First argument of Pagination class must be an array.";
            throw new InvalidArgumentException($msg);
        }

        $this->list = $list;
        
    }

    function getPage($num) {
        $offset = ($num + $this->rpp) -1 ;
        return array_slice($this->list, $offset, $this->rpp);
    }

    /** Get the id of the last page
     *
     */
    function getMaxPage() {
        return ceil(count($this->list)/$this->rpp);
    }

    /** Returns a styled HTML div containing links to the pages
     *
     * It simply adds URL parameter for the page based on the base link.
     * It will return '$baselink?page=xxx'.
     *
     */
    function getPageLinks($baselink) {
        $ret=" ";
        // Using a foreach-based loop in prevision of link building strategy
        foreach(range(1, $this->getMaxPage()) as $idx) {
            $ret = $ret . strval($idx) . " ";
            }
        
        return $ret;
    }
};
?>
