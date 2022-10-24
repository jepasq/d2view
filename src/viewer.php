<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');

$file = $_GET['file'];
$type = $_GET['type']; // Used to force type ?


/** Simply return the extension part of the filename using âthinfo()
 *
 * \return The 'extension' part of the pathinfo() extracted infos.
 *
 */
function getFileType($filename) {
    $path_parts = pathinfo($filename);
    return $path_parts['extension'];
}

if (empty($file)) {
    head("Viewer");
} else {
    head($file." - Viewer");
}
navbar("viewer");

if (empty($file) && empty($type)) {
    alert("This file viewer can be hard to use directly as a standalone
        feature. You may want to use it from the explorer instead.");
} else {
    echo "<section class='exporer-header'>";
    echo "Currently viewing : $file <br>";
    $type = getFileType($file);
    echo "File type :  $type <br>";
    echo "</section>";
}

$d2 = new D2View($dota);
$file_struct = $d2->get_file($file);
$ds = $file_struct->data_size;

echo "File size : $ds b  <br>";

if ($ype == '.txt') {
    if ($ds < 1000) {
        Echo "Text viewer :<br>";
        $content = $d2->get_file_content($file, $ds);
        echo "<pre class='viewer'>$content</pre>";
    } else {
        alert("Can't show a text file bigger than 1000b.");

    }

} else {
    alert("Can't find a suitable viewer for '$type' file extension.");
    
}

footer($start_time);

?>
