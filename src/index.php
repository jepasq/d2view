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

$home = $_SERVER['HOME'];
$dota = "$home/.steam/steam/steamapps/common/dota 2 beta/game/dota/";


$vpk_file = $dota.'pak01_dir.vpk';
$vpk = new VPKReader\VPK($vpk_file);
$ent_tree = $vpk->vpk_entries;

/*
$data = $vpk->read_file($dota.'pak01_000.vpk', 10000);
echo $data;
*/


// Based on https://stackoverflow.com/a/31685070
echo '<html><head>';
echo '<script type="text/javascript">
$("#chaps > li").click(function() {
  $(this).find("ul.assignments").toggleClass("hide");
});
</script>';

echo '<link href="style.css" rel="stylesheet" type="text/css">
</head>';

echo '<html><div id="chaps">';


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


$count_files=function($node, $pwd='') use (&$count_files){
    $count=0;
    if (is_countable($node)) {
        if(!is_null($node) && count($node) > 0) {
            if(is_array($node)){
                foreach($node as $name=>$subn) {
                    $count++;       
                }
            }else{ // Node
                $count++;
            }
        } else { // !countable
        }
    }
    return $count;
};


echo '</div></html></head>';

echo 'Total files :'.$count_files($ent_tree).'\n';

?>
