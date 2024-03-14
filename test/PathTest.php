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

        $this->assertStringContainsString("aze/tjk", $output);
        $this->assertStringContainsString("onClick", $output);
        $this->assertStringContainsString("Copy to clipboard", $output);

        // Must contain the notification span/div
        $this->assertStringContainsString("id='copied-to-cb'", $output);
    }    
};

?>
