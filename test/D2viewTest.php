<?php
use PHPUnit\Framework\TestCase;

require('config.php'); // Mainly for $home (needed by d2view)
// Please remenber that tests are called from root directory so, we need
// to explicitely call in src/.
include_once('src/d2view.php');


/** The D2View class test case
 *
 */
class D2viewTest extends TestCase
{
    /// The path to call D2View constructor with
    private $dota;

    /** Setup the test case before executing tests
     *
     */
    protected function setUp(): void {
        global $home;
        $this->dota = "$home/.steam/steam/steamapps/common/dota 2 beta/"
            ."game/dota/";
        echo "=> DOTA path is `$this->dota' (based on home '$home')\n";
    }

    /** Tear down instance members
     *
     */
    protected function teardown(): void {
        
    }

    
    /** Only test that the printTree member can be called
     *
     */
    public function testPrintTree()
    {
        // Should be defined. Only added to make current branch tests fail
        $this->assertTrue(defined('$this->dota'));

        $d2 = new D2View($this->dota);
        $ret = $d2->printTree(["cfg"], '', false);
        $this->assertTrue(empty($ret));
    }


    public function testListFiles()
    {
        $d2 = new D2View($this->dota);
        $ret = $d2->listFiles("cfg", false);
        $this->assertTrue(empty($ret));
    }

    public function testGetFile()
    {
        $d2 = new D2View($this->dota);
        $ret = $d2->getFile("cfg/frontpage_layout.txt");
        $this->assertFalse(empty($ret));

        $ret = $d2->getFile("cfg/this_file.doesnt_exist_NYI");
        $this->assertTrue(empty($ret));
    }

   
    public function testGetFileContent()
    {
        $d2 = new D2View($this->dota);
        $ret = $d2->getFileContent("cfg/frontpage_layout.txt", 1024);
        $this->assertFalse(empty($ret));
    }

    /// We had some issue with this particular file
    public function testGetFileContentException()
    {
        $d2 = new D2View($this->dota);
        // Real name is prepend with '/materials'
        $filen = "achievements/dota_achievement_placeholder.png";
        $this->expectException('VPKReader\Exception');
        $ret = $d2->getFileContent($filen, 1024);
    }
    
    /** Test for the first level array content
     *
     * The Dota 2 archive is known to have a 'cfg' directory in root folder.
     *
     */
    public function testQueryString_cfg()
    {
        $d2 = new D2View($this->dota);
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
        $d2 = new D2View($this->dota);
        $list = $d2->queryString(".png");

        $this->assertGreaterThan(0, count($list));
    }

    /** Shouldn't fire an error if no extension
     *
     */
    public function testViewerLink_withoutExtension()
    {
        $d2 = new D2View($this->dota);
        // We do not test output here. viewer_link() always return true
        // and onky echo() link
        $this->assertTrue($d2->viewer_link('ext'));
    }

    /** viewer_link should return true with an usable extension
     *
     */
    public function testViewerLink_withExtension()
    {
        $d2 = new D2View($this->dota);
        $this->assertTrue($d2->viewer_link('filename.ext'));
    }

    public function testQueryString_directory_separators()
    {
        $d2 = new D2View($this->dota);
        $list = $d2->queryString(".png");

        // Shoud contain subdirs separator (only keep first elements)
        $this->assertStringContainsString('/', implode('',
            array_slice($list, 0, 10)));
        // $this->assertSame(0, count($stack));
    }

    /// Test the new canHandleExtension() function implementation
    public function testCanHandleExtension()
    {
        $d2 = new D2View($this->dota);
        $this->assertTrue($d2->canHandleExtension('aze.txt'));
        $this->assertFalse($d2->canHandleExtension('aze.nottxt'));

        // If no extension
        $this->assertFalse($d2->canHandleExtension('azenot_tex'));

        // Should handle relative files
        $this->assertTrue($d2->canHandleExtension('subdir/name_aze.vert_c'));
    }
    
}
?>
