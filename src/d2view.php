<?php
include('VPKReader/Exception.php');
include('VPKReader/VPKHeader.php');
include('VPKReader/VPKDirectoryEntry.php');
include('VPKReader/VPKFile.php');
include('VPKReader/VPK.php');

/** A conditionnal echo that only prints if first argument is True
 *
 */
function _echo($print, $msg) {
    if ($print) {
        echo $msg;
    }
}

/** A central class to handle DotA2 VPK file
 *
 *  Mainly based on included VPKReader/ source code.
 *
 */
class D2view{
    public
    /** The number of paths in the DotA archive. If -1, Not yet computed */
    $nb_files, 
    $vpk_file; //!< The first .vpk file to be opened in dota_path
    

    /** A path-based constructor
     *
     * Will set vpk_file and nb_files to -1.
     *
     * \param $dota_path The dota path base (without the filename).
     *
     */
    function __construct($dota_path){
        $this->vpk_file = $dota_path.'pak01_dir.vpk';
        $this->nb_files = -1;
    }

    /** Print files from the given node
     *
     *  \param $node The parent node array.
     *  \param $pwd  The working dir used to print.
     *
     */
    function printTree($node, $pwd='', $print=true){
        $hide='';
        if(is_array($node)){
            // $name will contain path name
            
            // $subn the sub array
            foreach($node as $name=>$subn) {
                $fp = "$pwd/$name";
                if ($pwd == "/") {
                    $fp = $pwd.$name;
                }
                _echo ($print, '<tr>');
                if (is_countable($subn)) {
                    if (!empty(rtrim($name))) {
                        // Only print top-level items
                        $msg= "<td><a href='explorer.php?pwd=$fp'>$fp".
                            "</a>&nbsp;:".count($subn)." elements<td>";
                        _echo ($print, $msg);
                        $this->nb_files++;
                        //$printTree($subn, $pwd);
                    }
                } else {
                    $this->viewer_link($fp);
                }
                    _echo($print, '</tr>');
            }
        }else{ // is_array
            _echo ($print, "$node is not an array<br>");
        }
    }

    /** List all files found in an archive directory
     *
     * \param $pwd The working dir
     *
     */
    function listFiles($pwd, $print=true) {
        $this->nb_files=0;
        $vpk = new VPKReader\VPK($this->vpk_file);
        $ent_tree = $vpk->vpk_entries;

        $arr= '/';
        
        if ($pwd != '/') {
            $arr = $vpk->get_entry($pwd);
        } else {
            $arr = $ent_tree;
        }

        _echo ($print, "<a href='explorer.php?pwd=$pwd'>.</a><br>");
        if ($pwd != "/") {
            $zze = dirname($pwd);
            _echo ($print, "<a href='explorer.php?pwd=$zze'>..</a><br>");
        }
        
        _echo ($print, "<br>");

        _echo ($print, '<table>');
        $this->printTree($arr, $pwd, $print);
/*        _echo ($print, "<pre>");
        print_r($arr);
        _echo ($print, "</pre>");
        */
        _echo ($print, '</table>');
    }

    /** Return a VPKFile object
     *
     * \param $file The full path to the file inside the archive.
     *
     */
    function getFile($file) {
        $vpk = new VPKReader\VPK($this->vpk_file);
        return $vpk->get_entry($file);
    }

    /** Return the content of a file. You must know its size.
     *
     * \param $file The full path to the file inside the archive.
     * \param $size The size to the read in bytes.
     *
     */
    function getFileContent($file, $size) {
        $vpk = new VPKReader\VPK($this->vpk_file);
        return $vpk->read_file($file, $size);
    }

    /** Prints a viewer link
     *
     * \return false If we can't retrieve file extension. true otherwise.
     *
     */
    function viewer_link($file) {
        if ($this->canHandleExtension($file)) {       
            echo "<td>$file</td>
                <td><a href='viewer.php?file=$file'>[view]</a></td>";
            
        } else {
            echo "<td>$file</td>
            <td></td>
            <td><a href='viewer.php?file=$file'>[force view]</a></td>";
        }
        return true;
    }


    /** Feed the $ret array with $entries array entries that contains $query
     *
     * The test is done using str_contaisn and therefor is case-sensitive.
     *
     * \param $query The query string.
     * \param $ret   The array reference to be modified and will contain
     *               results.
     * \param $query The query string
     *
     */
    function _queryString_Impl($query, &$ret, $entries, $parent='') {
        foreach($entries as $name=>$subn) {
            if (str_contains($name, $query)) {
                //                echo "$name\n";
                if (empty($parent)) {
                    array_push($ret, $name);
                } else {
                    array_push($ret, $parent.'/'.$name);
                }
                
            }
            if (is_countable($subn)) {
                $this->_queryString_Impl($query, $ret, $subn, $name);
            }
        }
    }
    
    /** Returns a list of files whose filename contains the given query
     *
     * \param $query The query string
     *
     * \return An array of strings
     *
     */
    function queryString($query) {
        $ret = array();
        
        $vpk = new VPKReader\VPK($this->vpk_file);
        $ent_tree = $vpk->vpk_entries;
    //    echo "ent_tree content count :";
//        var_dump(count($ent_tree));

        $this->_queryString_Impl($query, $ret, $ent_tree);
  //      echo "_queryString_Impl content count :";
//        var_dump( count($ret) );
        
        return $ret;
    }

    /** Return true if we can correctly handle (i.e. view) filename extension
     *
     * \param $filename The filename to be tested.
     *
     * \return A boolean.
     *
     */
    function canHandleExtension($filename) {
        $path_parts = pathinfo($filename);
        $exts = array("txt", "vert_c");
        if (!array_key_exists("extension",$path_parts)){
            return false;    
        }
        $ext = $path_parts["extension"];
        return in_array($ext, $exts);
    }
};
?>
