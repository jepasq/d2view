<?php
use PHPUnit\Framework\TestCase;

include_once('src/Breadcrumb.php');
//require('config.php'); // Mainly for $home

/** An object used to navigate through an tree structure of directories
  *
  */
class BreadcrumbTest extends TestCase
{
    /** Test if we can instanciate Breadcrumb object.
     *
     * @group NoGameFiles
     *
     */
    public function testCtor()
    {
        // With no parameter
        $bc = new Breadcrumb(); 
        $this->assertFalse(empty($bc));

        // With a path parameter
        $bc = new Breadcrumb("/this/is/a/path", "pattern:%s"); 
        $this->assertFalse(empty($bc));

        // With a custom path separator
        $bc = new Breadcrumb(",this,is,a,path", ','); 
        $this->assertFalse(empty($bc));
    }

    public function testHrefNumber()
    {
        // With should have path number - 1 href
        $bc = new Breadcrumb("/this/is/a/path", "pattern:%s");
        $out = $bc->print();
        $this->assertEquals(substr_count($out, 'href'), 3);

        $bc = new Breadcrumb("/this/is/a/new/path", "pattern:%s");
        $out = $bc->print();
        $this->assertEquals(substr_count($out, 'href'), 4);
    }

    public function testPathSeparatorNumber()
    {
        $sep = '/';
        // With should have path number - 1 href
        $bc = new Breadcrumb("/this/is/a/path", "pattern:%s");
        $out = $bc->print();
        $this->assertEquals(substr_count($out, $sep), 3);

        $bc = new Breadcrumb("/this/is/a/new/path", "pattern:%s");
        $out = $bc->print();
        $this->assertEquals(substr_count($out, $sep), 4);
    }

    public function testPattern()
    {
        $bc = new Breadcrumb("/this/is/a/new/path", "pattern:%s");
        $out = $bc->print();
        $this->assertTrue(str_contains($out, 'pattern:/this'), 4);
        $this->assertTrue(str_contains($out, 'pattern:/this/is'), 4);
    }

    public function testhasPatter()
    {
        $bc = new Breadcrumb("/this/is/a/new/path");
        $this->assertTrue($bc->hasPattern("aze%sdfg"));
        $this->assertFalse($bc->hasPattern("azefg"));
        
    }    
};


?>

