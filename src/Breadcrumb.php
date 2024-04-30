<?php

// Thanks to https://stackoverflow.com/a/3654335
function remove_empty($array) {
    return array_filter($array, '_remove_empty_internal');
}
    
function _remove_empty_internal($value) {
    return !empty($value) || $value === 0;
}


/** A bootstrap 4 compliant breadcrumb used to navigate directory tree structure
  *
  * Used  https://getbootstrap.com/docs/4.0/components/breadcrumb/ as example.
  *
  */
class Breadcrumb
{
    public
    /** The current page index starting at 0. */
    $paths;

   
    function __construct($path = '', $separator = '/'){
        $this->paths = remove_empty(explode($separator, $path));
    }

    function print(){
        $ret = $sep = "/";
        foreach ($this->paths as $p) {
            if(end($this->paths) === $p) {
		        $ret .= $p;
	        } else {
             $ret .= "<a href=''>" . $p . "</a>" . $sep;
         }
        }
        return $ret;
    }

    
};

/* Bootstrap example :
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Library</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data</li>
  </ol>
</nav>
*/


?>

