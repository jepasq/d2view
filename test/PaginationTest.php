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
    
};

?>
