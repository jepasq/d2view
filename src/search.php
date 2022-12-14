<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');

$query=$_GET['query'];

if (empty($query)) {
    head("Search");
} else {
    head($query." - Search");
}

navbar("search");


echo "<section>
    <p>Search by file name :</p>";
echo "<form action='search.php' method='get'>
    <label for='query'>File name pattern :
    <input type='text' name='query' id='query' value='$query'
    minlength='3' required /></label>
    <input type='submit'></input>
  </form>";

echo "</section>";

if (!empty($query)) {
echo "<section>";
    global $dota;
    $d2 = new D2View($dota);
    $list = $d2->queryString($query);

    $co = count($list);
    
    echo "<em>Number of results for '$query' </em> :
        <strong>".$co."</strong>.<br>";

    if ($co > 100) {
        echo "(Only showing first 100 items)<br>";

        $list = array_slice($list, 0, 100);
    }
    
    foreach ($list as $item) {
        echo $item."<br>";
    }
echo "</section>";
}

footer($start_time);
?>

