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

    /*
    * @group NoGameFiles
    *
    */
    public function testHrefNumber()
    {
        // With should have path number - 1 href
        $bc = new Breadcrumb("/this/is/a/path", "pattern:%s");
        $out = $bc->toString();
        // Should be 0 pattern doesn't contains 'href'
        $this->assertEquals(substr_count($out, 'href'), 0);

        $bc = new Breadcrumb("/this/is/a/new/path", "pattern:%s");
        $out = $bc->toString();
        $this->assertEquals(substr_count($out, 'pattern'), 5);
    }

    /*
    * @group NoGameFiles
    *
    */
    public function testPathSeparatorNumber()
    {
        $sep = '/';
        // With should have path number - 1 href
        $bc = new Breadcrumb("/this/is/a/path", "pattern:%s");
        $out = $bc->toString();
        $this->assertEquals(substr_count($out, $sep), 4);

        $bc = new Breadcrumb("/this/is/a/new/path", "pattern:%s");
        $out = $bc->toString();
        $this->assertEquals(substr_count($out, $sep), 5);
    }

    /*
    * @group NoGameFiles
    *
    */
    public function testPattern()
    {
        $bc = new Breadcrumb("/this/is/a/new/path", "pattern:%s");
        $out = $bc->toString();
        // fwrite(STDERR, $out . '\n');
        $this->assertTrue(str_contains($out, 'pattern:this'));
        $this->assertTrue(str_contains($out, 'pattern:is'));
    }

    /*
    * @group NoGameFiles
    *
    */
    public function testHasPattern()
    {
        $bc = new Breadcrumb("/this/is/a/new/path");
        $this->assertTrue($bc->hasPattern("aze %s dfg"));
        $this->assertFalse($bc->hasPattern("azefg"));
    }

    /*
    * @group NoGameFiles
    *
    */
    public function testMultiplePattern()
    {
        $bc = new Breadcrumb("/path1/path2");
        $out = $bc->toString();
        // fwrite(STDERR, $out . '\n');
        $this->assertEquals(substr_count($out, 'path1'), 2);
    }    
    
};


?>

