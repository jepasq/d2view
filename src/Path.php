<?php

/** A class used to print a path with a copy HTML button
 *
 */
class Path {
    public

    /**The path location. Can be anything, nether tested */
    $path = '';

    /** The Path constructor
     *
     * \param $path The current path (non tested).
     *
     */
    function __construct($path){
        $this->path = $path;
    }

    /** Print the current path and add a copy to clipboard button
     */
    function printAndCopy() {
        return "<tt>$this->path</tt><button type='button'
            onClick='copyToClipboard(\"$this->path\");'>
            Copy to clipboard</button>
            <span id='copied-to-cb' style='display:none;'>Copied!</span>";
    }
};
?>
