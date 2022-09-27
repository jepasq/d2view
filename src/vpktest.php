<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');

$pwd = $_GET['pwd'];

head("vpktest");
navbar("vpktest");


echo "<section class='explorer-header'>
    <p>Current working dir : $pwd</p></section>";
echo "<section class='explorer'>
    <div class='explorer-content-header''>Content :</div>";

$print_tree = function($node, $pwd='') use (&$print_tree){
    if(!is_null($node) && count($node) > 0) {
        if(is_array($node)){
            echo '<ul>';
            foreach($node as $name=>$subn) {
                $fp = "$pwd/$name";
                echo "<li>$fp";
//                $print_tree($subn, $fp);
                echo '</li>';
            }
            echo '</ul>';
        }else{ // Node
            echo " | size: $node->size bytes";
        }
    }
};

try {
    $d2 = new D2View($dota);
    $df = $d2->vpk_file;
    $vpk = new VPKReader\VPK($df);
    $ent_tree = $vpk->vpk_entries;
    $print_tree($ent_tree[0]);
    
    echo '</section>';
} catch (VPKReader\Exception $e) {
    alert($e->getMessage());
}


footer($start_time);

?>
