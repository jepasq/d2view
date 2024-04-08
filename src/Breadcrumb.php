<?php

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
        $this->paths = explode($separator, $path);
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

