<?php
include('VPKReader/Exception.php');
include('VPKReader/VPKHeader.php');
include('VPKReader/VPKDirectoryEntry.php');
include('VPKReader/VPKFile.php');
include('VPKReader/VPK.php');

/*
echo get_include_path();
echo ini_get('include_path');
*/

$dota = "/home/rainbru/.steam/steam/steamapps/common/dota 2 beta/game/dota/";


$vpk_file = $dota.'pak01_dir.vpk';
$vpk = new VPKReader\VPK($vpk_file);
$ent_tree = $vpk->vpk_entries;

/*
$data = $vpk->read_file($dota.'pak01_000.vpk', 10000);
echo $data;
*/

$print_tree = function($node, $pwd='') use (&$print_tree){
    if (is_countable($node)) {
        if(!is_null($node) && count($node) > 0) {
            if(is_array($node)){
                echo '<ul>';
                foreach($node as $name=>$subn) {
                    $fp = "$pwd/$name";
                    echo "<li>$fp";
                    //  $print_tree($subn, $fp);
                    echo "</li>\n";
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
$print_tree($ent_tree);

?>
