<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');

$query=$_GET['query'];

if (empty($query)) {
    head("Search");
} else {
    include_once('Pagination.php');
    head($query." - Search");
}

navbar("search");

echo "<section>
    <div>Search by file name :</div>
    <div class='popsearch'><em>Popular search<em> :
      <a href='search.php?query=.png' title='All PNG images'>.png</a>, 
      <a href='search.php?query=.vpcf_c' title='Source 2 particles source'>
          .vpcf_c</a>
    </div>";
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

    $pag = new Pagination($list);
    if ($co > 100) {
        echo "(Only showing first 100 items)<br>";

        $list = $pag->getPage(0);
    }

    echo '<table>';
    foreach ($list as $item) {
        echo '<tr>';
        echo $d2->viewer_link($item);
        echo '</tr>';
    }
    echo '</table>';
    echo "</section>";

    echo($pag->getPageLinks("search.php?query=$query"));
}

footer($start_time);
?>

