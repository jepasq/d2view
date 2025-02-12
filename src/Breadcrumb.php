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
    $paths,
    /** The pattern where '%s' is replaced with individual path. */
    $pattern;

    /** The Breadcrumb constructor
      *
      * \param $path      The path string (default to an empty one).
      * \param $pattern   The pattern where '%s' will be replaced with
      *                   individual paths.
      * \param $separator The character used to split paths into directories.
      */
    function __construct($path = '', $pattern="%s", $separator = '/'){
        $this->setHrefPattern($pattern);
        $this->paths = remove_empty(explode($separator, $path));
    }

    /** Does the given string contains the actual pattern ?
     *
     * @param $str The string to be tested.
     *
     * @return true if the given string contains the actual pattern ('%s')
     *
     */
    function hasPattern($str) {
        return str_contains($str, $this->pattern);
    }

    /** Set the pattern
     *
     * \param $str The pattern the URL will be inserted in.
     *
     */
    function setHrefPattern($str) {
        if ($this->hasPattern($str)) {
            $this->pattern = $str;

            // Counting simple quote
            if (substr_count($str, "'")%2 == 1) {
                throw new InvalidArgumentException("Invalid number of simple quotes");
            }
            
        }
        else{
            throw new Exception("No pattern found");
        }
        
    }

    /** Return the printed breadcrumb as a string */
    function toString(){
        $ret = $sep = "/";
        foreach ($this->paths as $p) {
            if(end($this->paths) === $p) {
		        $ret .= str_replace('%s', $p, $this->pattern);
	        } else {
             $ret .= str_replace('%s', $p, $this->pattern) . $sep;
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

