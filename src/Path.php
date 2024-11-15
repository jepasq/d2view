<?php

/** A class used to get a path with a copy to clipboard HTML button
 *
 * The main way to use this is to set internal path member field as
 * constructor paramater and use printAndCopy() to get dull HTML markup.
 *
 *        $p = new Path('/aze/tjk');
 *        $output = $p->printAndCopy();
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

    /** Print the current path and add a Javascript-powered 'Copy to clipboard'
     *  button.
     *
     *  The called function @c copyToClipboard() can be found in the
     *  @c src/public/app.js file.
     *
     */
    function printAndCopy() {
        return "<tt>$this->path</tt><button type='button'
            onClick='copyToClipboard(\"$this->path\");'>
            Copy to clipboard</button>
            <span id='copied-to-cb' style='display:none;'>Copied!</span>";
    }
};
?>
