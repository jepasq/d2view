<?php
use PHPUnit\Framework\TestCase;

// Please remenber that tests are called from root directory so, no need
// to explicitely call in src/.
include_once('src/Pagination.php');
//require('config.php'); // Mainly for $home


/** The Pagination class test case
 *
 */
class PaginationTest extends TestCase
{
    /** Only test that the printTree member can be called
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

    public function testResultPerPage()
    {
        $l = array(1,1,2);
        $pag = new Pagination($l, 10);
        $this->assertEquals($pag->rpp, 10);

        $pag = new Pagination($l);       // Gloab default value
        $this->assertEquals($pag->rpp, 100);
    }

    /// Test that it throws an exception if 1st arg is not an array
    public function testNotAnArray()
    {
        $l = "Not an array";
        
        $this->expectException(InvalidArgumentException::class);
        $pag = new Pagination($l);
    }

    public function testGetPage()
    {
        $l = range(0,9);

        $pag = new Pagination($l);
        $p1 = $pag->getPage(0);
        $this->assertTrue(is_array($p1));
    }

    // Check the result array length
    public function testGetPage_ResultPage()
    {
        $l = range(0,9);
        $len = 3;
        
        $pag = new Pagination($l, $len);
        $p1 = $pag->getPage(0);
        $this->assertEquals(count($p1), $len);
    }

    // Check the second page content
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
    
    // Check the second page content
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

    public function testGetPageLinsk_IsAString()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $pl = $pag->getPageLinks("baselink/");
        $this->assertTrue(is_string($pl));
    }

    // Must individually contain 1, 2 and 3 characters
    public function testGetPageLinsk_Contains_123()
    {
        $l1 = range(0,9);
        $len = 3;
        $pag = new Pagination($l1, $len);
        $pl = $pag->getPageLinks("baselink/");
        $this->assertTrue(str_contains($pl, "1"));
        $this->assertTrue(str_contains($pl, "2"));
        $this->assertTrue(str_contains($pl, "3"));
    }
    
    
};

?>
