<?php

include('page_layout.php');
include('D2view.php');

head();
navbar();

$pwd = $_GET['pwd'];

echo "<p>Current working dir : $pwd</p>";
echo "<p>Content :</p>";


footer();

?>
