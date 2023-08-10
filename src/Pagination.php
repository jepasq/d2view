<?php


/** Handles pagination and related page linkes
 *
 * When result of a search is more that a page lenght, create links to
 * all pages.
 *
 */
class Pagination {
    public
    /** The current page index starting at 0. */
    $current_page,
    /** The list of element to be paginated. */
    $list,
    /** Result per page. */
    $rpp,
    /** Should we add three continuation dots if too much pages ? */
    $ellipsis,
    /** The character used as ellipsis char.  */
    $ellipsisChar = "&mldr;",
    /** How many pages before/after ellipsis. */
    $ellipsisThreshold = 3; 

    /** The Pagination constructor
     *
     * \param $list The list to be paginated.
     * \param $result_per_page
     * \param $start_page
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
        $this->ellipsis = true;
        
    }

    /** Get the conetnt of the given page
     *
     * \param $num The page number (starting at 0).
     *
     * \return The list sliced to only give the give page.
     *
     */
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

    /** Returns the link markup for a given page number
     *
     * \param $baselink   The base link URL.
     * \param $pagenumber The page number.
     *
     */
    function _pageLink($baselink, $pagenumber) {
        $sep = "?";
        if (str_contains($baselink, '?')) {
            $sep = "&";
        }
        
        return "<a href='$baselink".$sep."page=$pagenumber'>$pagenumber</a>";
    }
    
    /** Returns a styled HTML div containing links to the pages
     *
     * It simply adds URL parameter for the page based on the base link.
     * It will return '$baselink?page=xxx'.
     *
     * \param $baselink The page to redirect page links to. An URL parameter
     *                  will be added.
     *
     */
    function getPageLinks($baselink) {
        $ret="<section>";

        if ($this->ellipsis)
        {
            foreach(range(1, $this->ellipsisThreshold) as $idx) {
                $ret = $ret . $this->_pageLink($baselink, $idx) . "&nbsp;";
            }
            $ret .= $this->ellipsisChar;
            foreach(range($this->ellipsisThreshold+1, $this->getMaxPage())
                as $idx) {
                $ret = $ret . $this->_pageLink($baselink, $idx) . "&nbsp;";
            }

        } else {
            foreach(range(1, $this->getMaxPage()) as $idx) {
                $ret = $ret . $this->_pageLink($baselink, $idx) . "&nbsp;";
            }
        }
        
        $ret = $ret . "</section>";
        
        return $ret;
    }
};
?>
