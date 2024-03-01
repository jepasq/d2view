<?php


/** Handles pagination and related page linkes
 *
 * When result of a search is more that a page lenght, create links to
 * all pages.
 *
 */
class Path {
    public

    $path = '';

    function __construct($path){
        $this->path = $path;
    }

    /** Print the current path and add a copy to clipboard button
     */
    function printAndCopy() {
        return "<tt>$this->path</tt><button type='button'
            onClick='navigator.clipboard.writeText(\"$this->path\");>
            Copy to Clipboard</button>";
    }
};
?>
