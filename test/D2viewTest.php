<?php
use PHPUnit\Framework\TestCase;

// Please remenber that tests are called from root directory so, no need
// to explicitely call in src/.
include_once('src/d2view.php');
require('config.php'); // Mainly for $home

// We're not in the same directory than src/ sources. We can't just use
// global.php
$dota = "$home/.steam/steam/steamapps/common/dota 2 beta/game/dota/";


/** The D2View class test case
 *
 */
class D2viewTest extends TestCase
{
    /** Only test that the printTree member can be called
     *
     */
    public function testPrintTree()
    {
        global $dota;
        $d2 = new D2View($dota);
        $ret = $d2->printTree(["cfg"], '', false);
        $this->assertTrue(empty($ret));
    }
    

    public function testListFiles()
    {
        global $dota;
        $d2 = new D2View($dota);
        $ret = $d2->listFiles("cfg", false);
        $this->assertTrue(empty($ret));
    }

    public function testGetFile()
    {
        global $dota;
        $d2 = new D2View($dota);
        $ret = $d2->getFile("cfg/frontpage_layout.txt");
        $this->assertFalse(empty($ret));

        $ret = $d2->getFile("cfg/this_file.doesnt_exist_NYI");
        $this->assertTrue(empty($ret));
    }
    
    public function testGetFileContent()
    {
        global $dota;
        $d2 = new D2View($dota);
        $ret = $d2->getFileContent("cfg/frontpage_layout.txt", 1024);
        $this->assertFalse(empty($ret));
    }
    
    /** Test for the first level array content
     *
     * The Dota 2 archive is known to have a 'cfg' directory in root folder.
     *
     */
    public function testQueryString_cfg()
    {
        global $dota;
        $d2 = new D2View($dota);
        $list = $d2->queryString("cfg");

//        var_dump(count($list));
        // There is finally 2 'cfg' occurences (dota_keybinds.cfg, cfg)
        $this->assertSame(count($list), 2);
    }
    
    /** Test that calling the queryString function return a non empty list
     *
     */
    public function testQueryString_png()
    {
        global $dota;
        $d2 = new D2View($dota);
        $list = $d2->queryString(".png");

        $this->assertGreaterThan(0, count($list));
    }

    /** Shouldn't fire an error if no extension
     *
     */
    public function testViewerLink_withoutExtension()
    {
        global $dota;
        $d2 = new D2View($dota);
        // We do not test output here. viewer_link() always return true
        // and onky echo() link
        $this->assertTrue($d2->viewer_link('ext'));
    }

    /** viewer_link should return true with an usable extension
     *
     */
    public function testViewerLink_withExtension()
    {
        global $dota;
        $d2 = new D2View($dota);
        $this->assertTrue($d2->viewer_link('filename.ext'));
    }

    public function testQueryString_directory_separators()
    {
        global $dota;
        $d2 = new D2View($dota);
        $list = $d2->queryString(".png");

        // Shoud contain subdirs separator (only keep first elements)
        $this->assertStringContainsString('/', implode('',
            array_slice($list, 0, 10)));
        // $this->assertSame(0, count($stack));
    }

    /// Test the new canHandleExtension() function implementation
    public function testCanHandleExtension()
    {
        global $dota;
        $d2 = new D2View($dota);
        $this->assertTrue($d2->canHandleExtension('aze.txt'));
        $this->assertFalse($d2->canHandleExtension('aze.nottxt'));

        // If no extension
        $this->assertFalse($d2->canHandleExtension('azenot_tex'));

        // Should handle relative files
        $this->assertTrue($d2->canHandleExtension('subdir/name_aze.vert_c'));
    }
}
?>
