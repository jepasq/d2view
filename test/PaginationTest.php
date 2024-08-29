<?php
use PHPUnit\Framework\TestCase;

// Please remenber that tests are called from root directory so, no need
// to explicitely call in src/.
include_once('src/Pagination.php');
//require('config.php'); // Mainly for $home


/** The Pagination class test case
 *
 * Please use the NoGameFiles documentation group to make the test
 * runnable on CI.
 *
 */
class PaginationTest extends TestCase
{
    /** Only test that the printTree member can be called
     *
     * @group NoGameFiles
     *
     */
    public function testCtor()
    {
        // Args are $list, $result_per_page, $start_page
        $l = array(1,1,2);
        $pag = new Pagination($l, 10);    // 2 Args version
        $this->assertFalse(empty($pag));

        $pag = new Pagination($l, 10, 1); // 3 Args version
        $this->assertFalse(empty($pag));
        
        $pag = new Pagination($l);        // 1 Args version
        $this->assertFalse(empty($pag));
    }

    /** Test the result per page member
     *
     * @group NoGameFiles
     *
     */
    public function testResultPerPage()
    {
        $l = array(1,1,2);
        $pag = new Pagination($l, 10);
        $this->assertEquals($pag->rpp, 10);

        $pag = new Pagination($l);       // Gloab default value
        $this->assertEquals($pag->rpp, 100);
    }

    /** Test that it throws an exception if 1st arg is not an array
     *
     * @group NoGameFiles
     *
     */
    public function testNotAnArray()
    {
        $l = "Not an array";
        
        $this->expectException(InvalidArgumentException::class);
        $pag = new Pagination($l);
    }

    /** Test the getPage function
     *
     * @group NoGameFiles
     *
     */
    public function testGetPage()
    {
        $l = range(0,9);

        $pag = new Pagination($l);
        $p1 = $pag->getPage(0);
        $this->assertTrue(is_array($p1));
    }

    /** Check the getPage() result array length
     *
     * @group NoGameFiles
     *
     */
    public function testGetPage_ResultPage()
    {
        $l = range(0,9);
        $len = 3;
        
        $pag = new Pagination($l, $len);
        $p1 = $pag->getPage(0);
        $this->assertEquals(count($p1), $len);
    }

    /** Check the second page content
     *
     * @group NoGameFiles
     *
     */
    public function testGetPage_SecondPage()
    {
        $l = range(0,9);
        $len = 3;
        
        $pag = new Pagination($l, $len);
        $p2 = $pag->getPage(1);
        $should_be = range(3, 5);
        $diff = array_diff($p2, $should_be);
        $this->assertEquals(count($diff), 0);
    }
    
    /** Check the getMaxPage() return value
     *
     * @group NoGameFiles
     *
     */
    public function testGetMaxPage()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $this->assertEquals($pag->getMaxPage(), 4);

        $l2 = range(0,20);
        $pag = new Pagination($l2, 8);
        $this->assertEquals($pag->getMaxPage(), 3);
    }

    /** Check the getPageLinks() returned type
     *
     * @group NoGameFiles
     *
     */
    public function testGetPageLinks_IsAString()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $pl = $pag->getPageLinks("baselink/");
        $this->assertTrue(is_string($pl));
    }

    /** getPaheLinks must individually contain 1, 2 and 3 characters
     *
     * @group NoGameFiles
     *
     */
    public function testGetPageLinks_Contains_123()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $pl = $pag->getPageLinks("baselink/");
        $this->assertTrue(str_contains($pl, "1"));
        $this->assertTrue(str_contains($pl, "2"));
        $this->assertTrue(str_contains($pl, "3"));
    }

    // Check that returned string has at least one page as URL parameter
    public function testGetPageLinks_HasAPageParam()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $pl = $pag->getPageLinks("baselink/");
        $this->assertTrue(str_contains($pl, "page="));
    }

    // Check that we return exactly onr param parameter per page
    public function testGetPageLinks_PageParamCount()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $pl = $pag->getPageLinks("baselink/");
        $this->assertEquals(substr_count($pl, "page="), $pag->getMaxPage());
    }
    
    public function testGetPageLinks_HasSection()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        // Here I do not add closing tag to allow a class name
        $this->assertTrue(str_contains($pag->getPageLinks(""), "<section"));
        $this->assertTrue(str_contains($pag->getPageLinks(""), "</section>"));
    }

    public function testGetPageLinks_BaselinkHasParam()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);

        // If base link is a standard URL, add page with '?'
        $this->assertTrue(str_contains($pag->getPageLinks("http://url"),
        "?page"));
        
        // If base link already has a parameter, add with '&'
        $this->assertTrue(str_contains($pag->getPageLinks("url.com?param"),
        "&page"));
    }

    public function testGetPageLinks_NbLinks()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $stack = $pag->getPageLinks("http://url");
        $this->assertEquals(substr_count($stack, "//url"), 4);
    }

    /// Has a ellepsis property and check its default value
    public function testElipsisDefault()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $this->assertEquals($pag->ellipsis, true);
    }

    public function testElipsisIsModifiable()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $pag->ellipsis = false;
        $this->assertEquals($pag->ellipsis, false);
    }

    public function testElipsisChar()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $this->assertEquals($pag->ellipsisChar, "&mldr;");

        // And is modifiable
        $pag->ellipsisChar = "AAA";
        $this->assertEquals($pag->ellipsisChar, "AAA");
    }

    public function testElipsisThreshold()
    {
        // Has an ellipsisThreshold property
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $this->assertEquals($pag->ellipsisThreshold, 3);

        // And is modifiable
        $pag->ellipsisThreshold = 8;
        $this->assertEquals($pag->ellipsisThreshold, 8);
    }

    
    public function testElipsisHasAtLeastOne()
    {
        // Has an ellipsisThreshold property
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $stack = $pag->getPageLinks("http://url");
        $this->assertGreaterThan(0, substr_count($stack, $pag->ellipsisChar));
    }    
};

?>
