<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');

$file = $_GET['file'];
$type = $_GET['type']; // Used to force type ?


/** Simply return the extension part of the filename using pathinfo()
 *
 * \return The 'extension' part of the pathinfo() extracted infos.
 *
 */
function getFileType($filename) {
    $path_parts = pathinfo($filename);
    return $path_parts['extension'];
}

if ( !function_exists('sys_get_temp_dir')) {
  function sys_get_temp_dir() {
    if (!empty($_ENV['TMP'])) { return realpath($_ENV['TMP']); }
    if (!empty($_ENV['TMPDIR'])) { return realpath( $_ENV['TMPDIR']); }
    if (!empty($_ENV['TEMP'])) { return realpath( $_ENV['TEMP']); }
    $tempfile=tempnam(__FILE__,'');
    if (file_exists($tempfile)) {
      unlink($tempfile);
      return realpath(dirname($tempfile));
    }
    return null;
  }
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
$file_struct = $d2->getFile($file);
$ds = $file_struct->data_size;

echo "File size : $ds b  <br>";

if ($type == '.txt') {
    if ($ds < 1000) {
        Echo "Text viewer :<br>";
        $content = $d2->getFileContent($file, $ds);
        echo "<pre class='viewer'>$content</pre>";
    } else {
        alert("Can't show a text file bigger than 1000b.");

    }
}
else if ($type == 'png') {
    Echo "PNG Image viewer :<br>";
    try {
        $content = $d2->getFileContent($file, $ds);
        #        echo "<img src='data:image/png;base64,$content' />";

        # Trying to write file to disk
        $path = "/var/tmp/dotaimage.png"; //stream_get_meta_data($file)['uri'];
        if (!is_writable($path)) {
            echo "Error : $path is not writtable";
        }
        $file = fopen($path, 'w');
        #        $ret = file_put_contents($filename, $content);
        $ret = fwrite($file, $content);
        if (!$ret) {
            echo "Error writing image to '$path'";
        } else {
            echo "Writing image to '$path' with $ret bytes of content<br>";
            $ttmp=sys_get_temp_dir();
            echo "TMP is $ttmp<br>";
            echo "<img src='$ttmp'>";
        }
    } catch (Exception $e) {
        echo 'Exception : <em>',  $e->getMessage(), "</em>\n";
    }
        
} else {
    if (!empty($type)) {
        alert("Can't find a suitable viewer for '$type' file extension.");
    }
    
}

footer($start_time);

?>
