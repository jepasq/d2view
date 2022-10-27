<?php
include('VPKReader/Exception.php');
include('VPKReader/VPKHeader.php');
include('VPKReader/VPKDirectoryEntry.php');
include('VPKReader/VPKFile.php');
include('VPKReader/VPK.php');

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
    function print_tree($node, $pwd=''){
        $hide='';
        if(is_array($node)){
            // $name will contain path name
            
            // $subn the sub array
            foreach($node as $name=>$subn) {
                $fp = "$pwd/$name";
                if ($pwd == "/") {
                    $fp = $pwd.$name;
                }
                echo '<tr>';
                if (is_countable($subn)) {
                    if (!empty(rtrim($name))) {
                        // Only print top-level items
                        echo "<td><a href='explorer.php?pwd=$fp'>$fp</a>&nbsp;:".
                            count($subn)." elements<td>";
                        $this->nb_files++;
                        //$print_tree($subn, $pwd);
                    }
                } else {
                    $this->viewer_link($fp);
                }
/*                echo "<pre>";
                print_r($subn);
                echo "</pre>";*/
                    echo '</tr>';
            }
        }else{ // is_array
            echo "$node is not an array<br>";
            //            echo "$node : $node->size bytes<br>";
        }
    }

    /** List all files found in an archive directory
     *
     * \param $pwd The working dir
     *
     */
    function list_files($pwd) {
        $this->nb_files=0;
        $vpk = new VPKReader\VPK($this->vpk_file);
        $ent_tree = $vpk->vpk_entries;

        $arr= '/';
        
        if ($pwd != '/') {
            $arr = $vpk->get_entry($pwd);
        } else {
            $arr = $ent_tree;
        }

        echo "<a href='explorer.php?pwd=$pwd'>.</a><br>";
        if ($pwd != "/") {
            $zze = dirname($pwd);
            echo "<a href='explorer.php?pwd=$zze'>..</a><br>";
        }
        
        echo "<br>";

        echo '<table>';
        $this->print_tree($arr, $pwd);
/*        echo "<pre>";
        print_r($arr);
        echo "</pre>";
        */
        echo '</table>';
    }

    /** Return a VPKFile object
     *
     * \param $file The full path to the file inside the archive.
     *
     */
    function get_file($file) {
        $vpk = new VPKReader\VPK($this->vpk_file);
        return $vpk->get_entry($file);
    }

    /** Return the content of a file. You must know its size.
     *
     * \param $file The full path to the file inside the archive.
     * \param $size The size to the read in bytes.
     *
     */
    function get_file_content($file, $size) {
        $vpk = new VPKReader\VPK($this->vpk_file);
        return $vpk->read_file($file, $size);
    }


    function viewer_link($file) {
        $path_parts = pathinfo($file);
        $exts = array("txt", "vert_c");
        $ext = $path_parts["extension"];
        echo $ext;
        if (in_array($ext, $exts)) {
        
            echo "<td>$file</td>
                <td><a href='viewer.php?file=$file'>[view]</a></td>";
            
        } else {
            echo "<td>$file</td>
            <td></td>
            <td><a href='viewer.php?file=$file'>[force view]</a></td>";

        }
    }
};
?>
