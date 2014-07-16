<?php

namespace chippyash\Test\Matrix\Vector;

use chippyash\Matrix\Matrix;
use chippyash\Matrix\Vector\Vector2D;

/**
 * Unit test for Vector Class
 */
class VectorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Vector2D
     */
    protected $object;

    public function testConstructWithNoParametersGivesZeroVector()
    {
        $this->object = new Vector2D();
        $this->assertEquals(0, $this->object->getX());
        $this->assertEquals(0, $this->object->getY());
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\VectorException
     * @expectedExceptionMessage Vector exception: X is not numeric
     */
    public function testConstructWithNonNumericXThrowsException()
    {
        $this->object = new Vector2D('foo');
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\VectorException
     * @expectedExceptionMessage Vector exception: Y is not numeric
     */
    public function testConstructWithNonNumericYThrowsException()
    {
        $this->object = new Vector2D(0, 'foo');
    }

    public function testGetColVectorMatrixCanReturnTwoDimensions()
    {
        $this->object = new Vector2D(1,2);
        $test = new Matrix([[2],[1]]);
        $this->assertEquals($test,$this->object->toColVectorMatrix());
    }

    public function testTranslateWillTranslate()
    {
        $this->object = new Vector2D();
        $this->object->translate(
                function($x, $y, $val){return [1, 2, 3];});
        $this->assertEquals(1, $this->object->getX());
        $this->assertEquals(2, $this->object->getY());
        $this->assertEquals(3, $this->object->getValue());
    }

    public function testMagicToStringReturnsCorrectlyFormattedString()
    {
        $this->object = new Vector2D(3,5);
        $this->assertEquals("3,5", (string) $this->object);
    }

    public function testToYXStringReturnsCorrectlyFormattedString()
    {
        $this->object = new Vector2D(3,5);
        $this->assertEquals("5,3", $this->object->toYXString());
    }
}
