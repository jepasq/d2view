<?php
include('VPKReader/Exception.php');
include('VPKReader/VPKHeader.php');
include('VPKReader/VPKDirectoryEntry.php');
include('VPKReader/VPKFile.php');
include('VPKReader/VPK.php');

class D2view{
    public
        $nb_files, //!< The number of paths in the DotA archive
        $vpk_file; //!< The first .vpk file to be opened in dota_path
    
    
    function __construct($dota_path){
        $this->vpk_file = $dota.'pak01_dir.vpk';
        $this->nb_files = 0;

        $print_tree = function($node, $pwd='') use (&$print_tree){
            $hide='';
            if (is_countable($node)) {
                if(!is_null($node) && count($node) > 0) {
                    if(is_array($node)){
                        echo "<ul class='assignments $hide'>";
                        foreach($node as $name=>$subn) {
                            $fp = "$pwd/$name";
                            echo "<li>$fp";
                            /*                    $hide='hide';
                                                  $print_tree($subn, $fp);
                                                  $hide='';
                            */
                            echo "</li>\n";
                            $this->nb_files++;     
                        }
                        echo '</ul>';
                    }else{ // Node
                        echo " | size: $node->size bytes";
                    }
                } else { // !countable
                    echo "Not countable\n";
                }
            }
        };
        //$print_tree($ent_tree);
        
        
    }
};
?>
