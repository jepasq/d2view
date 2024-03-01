<?php
use PHPUnit\Framework\TestCase;

// Please remenber that tests are called from root directory so, no need
// to explicitely call in src/.
include_once('src/Path.php');


/** The Path test case
 *
 */
class PathTest extends TestCase
{
    /** Only test that the printTree member can be called
     *
     * @group NoGameFiles
     *
     */
    public function testCtor()
    {
        $p = new Path('/aze/tjk');
        $output = $p->printAndCopy();

        echo $output;
        
        $this->assertTrue(str_contains($output, "aze/tjk"));
        $this->assertTrue(str_contains($output, "onClick"));
        
    }    
};

?>
