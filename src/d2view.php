<?php
include('VPKReader/Exception.php');
include('VPKReader/VPKHeader.php');
include('VPKReader/VPKDirectoryEntry.php');
include('VPKReader/VPKFile.php');
include('VPKReader/VPK.php');

class D2view{
    public
        /** The number of paths in the DotA archive. If -1, Not yet computed */
        $nb_files, 
        $vpk_file; //!< The first .vpk file to be opened in dota_path
    
    
    function __construct($dota_path){
        $this->vpk_file = $dota_path.'pak01_dir.vpk';
        $this->nb_files = -1;

    }

    function print_tree($node, $pwd=''){
        $hide='';
        if (is_countable($node)) {
            if(!is_null($node) && count($node) > 0) {
                if(is_array($node)){
                    foreach($node as $name=>$subn) {
                        $fp = "$pwd/$name";
                        // Only print top-level items
                        echo "<a href='explorer.php?pwd=$fp'>$fp</a><br>";
                        $this->nb_files++;
                        //$print_tree($subn, $pwd);
                        
                    }
                }else{ // Node
                    echo "$node<br>";
                    //                            echo $fp;
                }
            }
        }
    }

    
    function list_files($pwd) {
        $this->nb_files=0;
        $vpk = new VPKReader\VPK($this->vpk_file);
        $ent_tree = $vpk->vpk_entries;
        
        $this->print_tree($ent_tree, $pwd);
        
        
    }

};
?>
