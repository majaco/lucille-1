<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\Uri;
use Lucille\Request\UriRegEx;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\Uri
 */
class UriTest extends TestCase {

    /**
     * @covers ::asString
     * @covers ::__construct
     */
    public function testReturnsInitialUri() {
        $uri = new Uri('/foo/bar/1234');
        $this->assertEquals('/foo/bar/1234', $uri->asString());
    }
    
    /**
     * @covers ::asString
     * @uses   \Lucille\Request\Uri::__construct
     */
    public function testReturnsInitialUriAsPath() {
        $uri = new Uri('/foo/bar/1234/test.xml?test=123#foo');
        $this->assertEquals('/foo/bar/1234/test.xml', $uri->asString());
    }
    
    /**
     * @covers ::originUriAsString
     * @uses   \Lucille\Request\Uri::__construct
     */
    public function testReturnsOriginUri() {
        $x = '/foo/bar/1234/test.xml?test=123#foo';
        $uri = new Uri($x);
        $this->assertEquals($x, $uri->originUriAsString());
    }
    
    /**
     * @covers ::isEqual
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\Uri::asString
     */
    public function testUriIsEqualToAnotherUri() {
        $url = new Uri('/foo/bar/1234');
        $this->assertTrue($url->isEqual($url));
    }

    /**
     * @covers ::isEqual
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\Uri::asString
     */
    public function testUriIsNotEqualToAnotherUri() {
        $url = new Uri('/foo/bar/1234');
        $this->assertFalse($url->isEqual(new Uri('/res/demo')));
    }
    
    /**
     * @covers ::beginsWith
     * @uses   Lucille\Request\Uri::__construct
     * @uses   Lucille\Request\Uri::asString
     */
    public function testUriBeginsWithMatchesSpecifiedUri() {
        $url = new Uri('/foo/bar/1234');
        $this->assertTrue($url->beginsWith(new Uri('/foo/b')));
    }

    /**
     * @covers ::beginsWith
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\Uri::asString
     */
    public function testUriBeginsWithDoesNotMatchSpecifiedUri() {
        $url = new Uri('/foo/bar/1234');
        $this->assertFalse($url->beginsWith(new Uri('/resource')));
    }
    
    /**
     * @covers ::matchesRegEx
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\UriRegEx
     */
    public function testUriValueMatchesRegExPattern() {
        $url = new Uri('/foo/bar/1234');
        $test = $url->matchesRegEx(new UriRegEx("#^\/[a-z]*\/bar\/1234#"));
        $this->assertTrue($test);
    }
    
    /**
     * @covers ::matchesRegEx
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\UriRegEx
     */
    public function testUriValueDoesNotMatchRegExPattern() {
        $url = new Uri('/foo/bar/1234');
        $test = $url->matchesRegEx(new UriRegEx("#^\/[0-9]*\/bar\/1234#"));
        $this->assertFalse($test);
    }

    /**
     * @covers ::getPart
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\Uri::asString
     * @uses   \Lucille\Request\UriPart
     */
    public function testReturnsUriPartByIndex() {
        $uri = new Uri('/document/demo/123');
        $this->assertEquals('document', $uri->getPart(0)->asString());
        $this->assertEquals('demo', $uri->getPart(1)->asString());
        $this->assertEquals('123', $uri->getPart(2)->asString());
    }
    
    /**
     * @covers ::getPart
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\Uri::asString
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\UriPartIndexOutOfBoundsException::__construct
     * @uses   \Lucille\Request\UriPart
     * @expectedException \Lucille\Exceptions\UriPartIndexOutOfBoundsException
     */
    public function testGetUriPartNegativeIndexThrowsException() {
        $uri = new Uri('/document/demo/123');
        $this->assertEquals('document', $uri->getPart(-2)->asString());
    }
    
    /**
     * @covers ::getPart
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\Uri::asString
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\UriPartIndexOutOfBoundsException::__construct
     * @expectedException \Lucille\Exceptions\UriPartIndexOutOfBoundsException
     */
    public function testGetUriPartOutOfBoundsIndexThrowsException() {
        $uri = new Uri('/document/demo/123');
        $uri->getPart(5);
    }
    
}
    
