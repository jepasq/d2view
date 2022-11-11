<?php
use PHPUnit\Framework\TestCase;

// Please remenber that tests are called from root directory so, no need
// to explicitely call in src/.
include_once('src/d2view.php');
require('config.php'); // Mainly for $home

// We're not in the same directory than src/ sources. We can't just use
// global.php
$dota = "$home/.steam/steam/steamapps/common/dota 2 beta/game/dota/";


class D2viewTest extends TestCase
{
    public function testPushAndPop()
    {
        global $dota;
        $d2 = new D2View($dota);
        $list = $d2->queryString(".png");

        $this->assertGreaterThan(count($list), 0);
        // $this->assertSame(0, count($stack));
    }
}
?>
