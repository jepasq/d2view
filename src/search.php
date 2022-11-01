<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');

head("Search");
navbar("search");


echo "<section>
    <p>Search by file name :</p>";
echo "<form>
    <label for='query'>File name pattern :
      <input type='text' id='query' minlength='3' required /></label>
    <input type='submit'></input>
  </form>";

echo "</section>";

footer($start_time);
?>

