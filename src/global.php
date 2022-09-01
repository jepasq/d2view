<?php

$cfg = '../config.php';
if (file_exists($cfg)) {
    include($cfg);
} else {
    alert("<em>$cfg</em> file can't be found. You <b>must</b> create it.");
    exit(1);
}
$dota = "$home/.steam/steam/steamapps/common/dota 2 beta/game/dota/";


?>
