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
        fwrite(STDERR, "\n" . $out . "\n");
        $this->assertEquals(substr_count($out, 'path1'), 2);
    }    

    /** Check the infamous case where we didn't correctly close the quote
     *
     * @group NoGameFiles
     *
     */
    public function testPatternQuoteNoEnd()
    {
        $bc = new Breadcrumb("/path1/path2");
        $out = $bc->toString();

        // Could be a custom 'UnclosedQuoteException' one
        $this->expectException(InvalidArgumentException::class);
        $bc->setHrefPattern("path1pattern %s with unclosed 'simpleq");
    }    

    /** Check if we don't have a double slash between path element
     *
     * @group NoGameFiles
     *
     */
    public function testPatternDoubleSlash()
    {
        $bc = new Breadcrumb('/media/expl/', "<a href='ex.php?pwd=%s'>%s</a>/");
        $out = $bc->toString();

        fwrite(STDERR, "\n> DoubleSlash: " . $out . "\n");
        $this->assertEquals(substr_count($out, '//'), 0);
    }
    
};


?>

